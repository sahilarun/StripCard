import 'package:stripcard/widgets/text_labels/custom_title_heading_widget.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../../backend/model/common/common_success_model.dart';
import '../../backend/model/kyc/kyc_info_model.dart';
import '../../backend/services/api_services.dart';
import '../../language/strings.dart';
import '../../routes/routes.dart';
import '../../utils/custom_color.dart';
import '../../utils/custom_style.dart';
import '../../utils/dimensions.dart';
import '../../utils/size.dart';
import '../../views/kyc/kyc_dynamic_dropdown.dart';
import '../../views/kyc/kyc_dynamic_image_widget.dart';
import '../../widgets/inputs/primary_input_filed.dart';
import '../../widgets/others/congratulation_widget.dart';
class KycController extends GetxController {
  @override
  void onInit() {
     getKycInputFieldsProcess() ;
    super.onInit();
  }

  final _isLoading = false.obs;

  bool get isLoading => _isLoading.value;

  List<TextEditingController> inputFieldControllers = [];
  final trackController = TextEditingController();
  RxList inputFields = [].obs;

  List<String> dropdownList = <String>[].obs;

  //creating bank name and code dropdowns
  RxString selectType = "".obs;

  List<String> listImagePath = [];
  List<String> listFieldName = [];
  RxBool hasFile = false.obs;

  RxString trx = ''.obs;

  late KycInfoModel _kycInfoModel;

  KycInfoModel get kycInfoModel => _kycInfoModel;

  //add money payment gateway function
  Future<KycInfoModel> getKycInputFieldsProcess() async {
    _isLoading.value = true;
    inputFields.clear();
    listImagePath.clear();
    listFieldName.clear();
    inputFieldControllers.clear();
    update();

    await ApiServices.kycInputFieldsApi().then((value) {
      _kycInfoModel = value!;
      //-------------------------- Process inputs start ------------------------
      final data = _kycInfoModel.data.inputFields;

      for (int item = 0; item < data.length; item++) {
        // make the dynamic controller
        var textEditingController = TextEditingController();
        inputFieldControllers.add(textEditingController);

        // make dynamic input widget

        // make dynamic input widget
        if (data[item].type.contains('select')) {
          hasFile.value = true;
          selectType.value = data[item].validation.options.first.toString();
          inputFieldControllers[item].text = selectType.value;
          dropdownList = data[item].validation.options;
          inputFields.add(
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                SizedBox(
                  height: Dimensions.marginBetweenInputTitleAndBox,
                ),
                CustomTitleHeadingWidget(
                  text: data[item].label,
                  style: CustomStyle.darkHeading4TextStyle.copyWith(
                    fontWeight: FontWeight.w600,
                    color: CustomColor.primaryLightTextColor,
                  ),
                ),
                SizedBox(
                  height: Dimensions.marginBetweenInputTitleAndBox,
                ),
                KycDynamicDropDown(
                  selectMethod: selectType,
                  itemsList: dropdownList,
                  onChanged: (value) {
                    selectType.value = value!;
                    inputFieldControllers[item].text = selectType.value;
                    debugPrint(selectType.value);
                  },
                ),
              ],
            ),
          );
        } else if (data[item].type.contains('file')) {
          hasFile.value = true;
          inputFields.add(
            Column(
              mainAxisAlignment: mainStart,
              crossAxisAlignment: crossStart,
              children: [
                SizedBox(
                  height: Dimensions.marginBetweenInputTitleAndBox,
                ),
                CustomTitleHeadingWidget(
                  text: data[item].label,
                  style: CustomStyle.darkHeading4TextStyle.copyWith(
                    fontWeight: FontWeight.w600,
                    color: CustomColor.primaryLightTextColor,
                  ),
                ),
                SizedBox(
                  height: Dimensions.marginBetweenInputTitleAndBox,
                ),
                Padding(
                  padding: const EdgeInsets.only(bottom: 8.0),
                  child: KycImageWidget(
                    labelName: data[item].label,
                    fieldName: data[item].name,
                  ),
                ),
              ],
            ),
          );
        } else if (data[item].type.contains('text')) {
          inputFields.add(
            Column(
              mainAxisAlignment: mainStart,
              crossAxisAlignment: crossStart,
              children: [
                SizedBox(
                  height: Dimensions.marginBetweenInputTitleAndBox,
                ),
                PrimaryInputWidget(
                  controller: inputFieldControllers[item],
                  hint: '${Strings.enter} ${data[item].label}',
                  label: data[item].label,
                ),
              ],
            ),
          );
        }
      }

      update();
    }).catchError((onError) {
      log.e(onError);
      _isLoading.value = false;
      update();
    });

    _isLoading.value = false;
    update();
    return _kycInfoModel;
  }
//-----------------submit manual add money--------------------

  late CommonSuccessModel _commonSuccessModel;

  CommonSuccessModel get commonSuccessModel => _commonSuccessModel;

  Future<CommonSuccessModel> submitKycProcess(
      {required BuildContext context}) async {
    _isLoading.value = true;
    Map<String, String> inputBody = {};

    final data = kycInfoModel.data.inputFields;

    for (int i = 0; i < data.length; i += 1) {
      if (data[i].type != 'file') {
        inputBody[data[i].name] = inputFieldControllers[i].text;
      }
    }

    await ApiServices.submitKycApi(
            body: inputBody, fieldList: listFieldName, pathList: listImagePath)
        .then((value) {
      _commonSuccessModel = value!;
      confirmButtonClick(
          context: context,
          message: _commonSuccessModel.message.success.first.toString());
      inputFields.clear();
      listImagePath.clear();
      listFieldName.clear();
      inputFieldControllers.clear();
      _isLoading.value = false;
      update();
    }).catchError((onError) {
      log.e(onError);
      _isLoading.value = false;
    });
    _isLoading.value = false;
    update();
    return _commonSuccessModel;
  }

  void confirmButtonClick(
      {required BuildContext context, required String message}) {
    StatusScreen.show(
        context: context,
        subTitle: Strings.kycSuccessMessage.tr,
        onPressed: () {
          Get.offAllNamed(Routes.bottomNavBarScreen);
        });
  }
}
