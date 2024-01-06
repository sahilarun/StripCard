import 'package:flutter/services.dart';
import '../../../backend/model/add_money/manual_payment_getway_model.dart';
import '../../../backend/model/common/common_success_model.dart';
import '../../../backend/services/api_services.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../widgets/inputs/primary_input_filed.dart';
import '../../../widgets/others/congratulation_widget.dart';
import '../../../widgets/others/manual_payment_image_widget.dart';

class ManualPaymentController extends GetxController {
  List<TextEditingController> inputFieldControllers = [];
  final trackController = TextEditingController();
  RxList inputFields = [].obs;
  List<String> listImagePath = [];
  List<String> listFieldName = [];
  RxBool hasFile = false.obs;

  RxString trx = ''.obs;
  RxString selectedCurrencyAlias = "".obs;

  RxString willGet = "".obs;
  RxString totalPayable = "".obs;
  RxString feeCharge = "".obs;



  final _isLoading = false.obs;

  bool get isLoading => _isLoading.value;

  late ManualPaymentGatewayModel _manualPaymentGetGatewayModel;

  ManualPaymentGatewayModel get manualPaymentGetGatewayModel =>
      _manualPaymentGetGatewayModel;

  // --------------------------- Api function ----------------------------------
  // Manual Payment Get Gateway process function
  Future<ManualPaymentGatewayModel> manualPaymentGatewaysProcess(
      inputBody) async {
    _isLoading.value = true;
    inputFields.clear();
    listImagePath.clear();
    listFieldName.clear();
    inputFieldControllers.clear();
    update();

    await ApiServices.manualPaymentApi(body: inputBody).then((value) {
      _manualPaymentGetGatewayModel = value!;
      //-------------------------- Process inputs start ------------------------
      final data = _manualPaymentGetGatewayModel.data.inputFields;

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
                    verticalSpace(Dimensions.heightSize*.8),
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
                verticalSpace(Dimensions.heightSize*0.3),
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
              ],
            ),
          );
        }
      }
      trx.value = _manualPaymentGetGatewayModel.data.paymentInformations.trx;
      feeCharge.value =
          _manualPaymentGetGatewayModel.data.paymentInformations.totalCharge;
      totalPayable.value =
          _manualPaymentGetGatewayModel.data.paymentInformations.payableAmount;
      willGet.value =
          _manualPaymentGetGatewayModel.data.paymentInformations.willGet;
      _isLoading.value = false;
      Get.toNamed(Routes.manualPaymentScreen);
      update();
    }).catchError((onError) {
      _isLoading.value = false;
      log.e(onError);
    });

    update();
    return _manualPaymentGetGatewayModel;
  }

  final _isConfirmLoading = false.obs;

  bool get isConfirmLoading => _isConfirmLoading.value;

  late CommonSuccessModel _manualPaymentConfirmModel;

  CommonSuccessModel get manualPaymentConfirmModel =>
      _manualPaymentConfirmModel;

  Future<CommonSuccessModel> manualPaymentProcess(context) async {
    _isConfirmLoading.value = true;
    Map<String, String> inputBody = {
      'track': trx.value,
    };
    final data = manualPaymentGetGatewayModel.data.inputFields;

    for (int i = 0; i < data.length; i += 1) {
      if (data[i].type != 'file') {
        inputBody[data[i].name] = inputFieldControllers[i].text;
      }
    }

    await ApiServices.addMoneyManualConfirmedApi(
            body: inputBody, fieldList: listFieldName, pathList: listImagePath)
        .then((value) {
      _manualPaymentConfirmModel = value!;
      _isConfirmLoading.value = false;
      update();

      _goToSuccessScreen(context);
    }).catchError((onError) {
      log.e(onError);
      _isConfirmLoading.value = false;
    });
    _isConfirmLoading.value = false;
    update();
    return _manualPaymentConfirmModel;
  }

  void _goToSuccessScreen(context) {
    StatusScreen.show(
        context: context,
        subTitle: Strings.yourMoneyAddedSucces.tr,
        onPressed: () {
          Get.offAllNamed(Routes.bottomNavBarScreen);
        });
  }
}
