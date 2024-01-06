import 'package:flutter/services.dart';
import 'package:stripcard/backend/services/api_services.dart';
import '../../../backend/model/common/common_success_model.dart';
import '../../../backend/model/withdraw/dynamic_input_withdraw_model.dart';
import '../../../backend/model/withdraw/withdraw_info_model.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../widgets/inputs/primary_input_filed.dart';
import '../../../widgets/others/congratulation_widget.dart';
import '../../../widgets/others/manual_payment_image_widget.dart';

class MoneyOutController extends GetxController {
  final moneyOutAmountTextController = TextEditingController();
  RxString selectedCurrencyAlias = "".obs;
  RxString selectedCurrencyName = "".obs;
  RxDouble amount = 0.0.obs;
  RxString baseCurrency = "".obs;
  RxDouble fixesCharge = 0.0.obs;
  RxDouble limitMin = 0.0.obs;
  RxDouble limitMax = 0.0.obs;
  List<TextEditingController> inputFieldControllers = [];
  RxList inputFields = [].obs;
  RxBool hasFile = false.obs;
  List<Currency> allCurrencyList = [];
  RxString selectAlias = "".obs;
  List<String> listImagePath = [];
  List<String> listFieldName = [];
  String requestAmount = "";
  String totalCharge = "";
  String youWillGet = "";
  String exchangeRate = "";
  String payableAmount = "";

  List<String> totalAmount = [];
  @override
  void dispose() {
    moneyOutAmountTextController.dispose();

    super.dispose();
  }

  @override
  void onInit() {
    getMoneyOutData();

    super.onInit();
  }

// get wallet
  final _isLoading = false.obs;

  bool get isLoading => _isLoading.value;

  late WithdrawInfoModel _withdrawInfoModel;

  WithdrawInfoModel get withdrawInfoModel => _withdrawInfoModel;

  Future<WithdrawInfoModel> getMoneyOutData() async {
    _isLoading.value = true;
    update();
    await ApiServices.withdrawInfoApi().then((value) {
      _withdrawInfoModel = value!;

      for (var gateways in withdrawInfoModel.data.gateways) {
        for (var currency in gateways.currencies) {
          allCurrencyList.add(
            Currency(
              createdAt: currency.createdAt,
              updatedAt: currency.updatedAt,
              id: currency.id,
              paymentGatewayId: currency.paymentGatewayId,
              name: currency.name,
              alias: currency.alias,
              currencyCode: currency.currencyCode,
              currencySymbol: currency.currencySymbol,
              minLimit: currency.minLimit,
              maxLimit: currency.maxLimit,
              percentCharge: currency.percentCharge,
              fixedCharge: currency.fixedCharge,
              rate: currency.rate,
              type: currency.type,
              image: currency.image,
            ),
          );
        }
        baseCurrency.value = _withdrawInfoModel.data.baseCurr;
        Currency currency =
            withdrawInfoModel.data.gateways.first.currencies.first;
        selectedCurrencyName.value = currency.name;
        selectAlias.value = currency.alias;
        limitMin.value = currency.minLimit.toDouble();
        limitMax.value = currency.maxLimit.toDouble();

        fixesCharge.value = currency.fixedCharge.toDouble();
      }

      _isLoading.value = false;

      update();
    }).catchError((onError) {
      log.e(onError);
    });

    _isLoading.value = false;
    update();
    return _withdrawInfoModel;
  }

  goToMoneyOutPreviewScreen() {
    Get.toNamed(Routes.moneyOutPreviewScreen);
  }

  final _isInsertLoading = false.obs;
  bool get isInsertLoading => _isInsertLoading.value;
//money out insert process

  late DynamicInputWithdrawModel _moneyOutInsertModel;

  DynamicInputWithdrawModel get moneyOutInsertModel => _moneyOutInsertModel;

  ///* A -dd Money manual insert api process start
  Future<DynamicInputWithdrawModel> manualPaymentGetGatewaysProcess() async {
    _isInsertLoading.value = true;
    inputFields.clear();
    listImagePath.clear();
    listFieldName.clear();
    inputFieldControllers.clear();
    update();

    Map<String, dynamic> inputBody = {
      'amount': moneyOutAmountTextController.text,
      'gateway': selectAlias.value,
    };

    await ApiServices.withdrawInsertApi(body: inputBody).then((value) {
      _moneyOutInsertModel = value!;

      final previewData = _moneyOutInsertModel.data.paymentInformations;
      requestAmount = previewData.requestAmount;
      totalCharge = previewData.totalCharge;
      youWillGet = previewData.willGet;
      exchangeRate = previewData.exchangeRate;
      payableAmount = previewData.payable;

      ///* Add money manual insert api process start
      final data = _moneyOutInsertModel.data.inputFields;

      for (int item = 0; item < data.length; item++) {
        // make the dynamic controller
        var textEditingController = TextEditingController();
        inputFieldControllers.add(textEditingController);

        // make dynamic input widget
        if (data[item].type.contains('file')) {
          hasFile.value = true;
          inputFields.add(
            Container(
              child: Padding(
                padding: const EdgeInsets.only(bottom: 8.0, top: 8.0),
                child: Column(
                  crossAxisAlignment: crossStart,
                  children: [
                    Text(
                      Strings.screenshot,
                      style: CustomStyle.darkHeading4TextStyle.copyWith(
                        fontWeight: FontWeight.w600,
                        color: CustomColor.primaryLightTextColor,
                      ),
                    ),
                    verticalSpace(Dimensions.heightSize * .8),
                    ManualPaymentImageWidget(
                      labelName: data[item].label,
                      fieldName: data[item].name,
                    ),
                  ],
                ),
              ),
            ),
          );
        } else if (data[item].type.contains('text') ||
            data[item].type.contains('textarea')) {
          inputFields.add(
            Column(
              children: [
                PrimaryInputWidget(
                  paddings: EdgeInsets.only(
                      left: Dimensions.widthSize,
                      right: Dimensions.widthSize,
                      top: Dimensions.heightSize * 0.5),
                  controller: inputFieldControllers[item],
                  hint: data[item].label,
                  isValidator: data[item].required,
                  label: data[item].label,
                  inputFormatters: [
                    LengthLimitingTextInputFormatter(
                      int.parse(
                        data[item].validation.max.toString(),
                      ),
                    ),
                  ],
                ),
                verticalSpace(Dimensions.heightSize * 0.5),
              ],
            ),
          );
        }
      }

      //-------------------------- Process inputs end --------------------------
      Get.toNamed(Routes.moneyOutManualPaymentScreen);
      _isInsertLoading.value = false;

      update();
    }).catchError((onError) {
      _isInsertLoading.value = false;
      log.e(onError);
    });

    update();
    return _moneyOutInsertModel;
  }

  final _isConfirmLoading = false.obs;
  bool get isConfirmLoading => _isConfirmLoading.value;
  //! ---------------------------- Add Money Manual Payment Process -------------------------

  late CommonSuccessModel _manualPaymentConfirmModel;
  CommonSuccessModel get manualPaymentConfirmModel =>
      _manualPaymentConfirmModel;

  Future<CommonSuccessModel> confirmProcess(context) async {
    _isConfirmLoading.value = true;
    Map<String, String> inputBody = {
      'trx': moneyOutInsertModel.data.paymentInformations.trx,
    };

    final data = moneyOutInsertModel.data.inputFields;

    for (int i = 0; i < data.length; i += 1) {
      if (data[i].type != 'file') {
        inputBody[data[i].name] = inputFieldControllers[i].text;
      }
    }

    await ApiServices.withdrawSubmitApi(
            body: inputBody, fieldList: listFieldName, pathList: listImagePath)
        .then((value) {
      _manualPaymentConfirmModel = value!;
      _goToSuccessScreen(context);

      _isConfirmLoading.value = false;
      update();
    }).catchError((onError) {
      log.e(onError);
    });
    _isConfirmLoading.value = false;
    update();
    return _manualPaymentConfirmModel;
  }

  void _goToSuccessScreen(context) {
    StatusScreen.show(
        context: context,
        subTitle: Strings.yourMoneyWithdrawSuccess.tr,
        onPressed: () {
          Get.offAllNamed(Routes.bottomNavBarScreen);
        });
  }
}
