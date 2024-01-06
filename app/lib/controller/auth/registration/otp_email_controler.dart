import 'dart:async';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../../backend/local_storage.dart';
import '../../../backend/model/auth/sign_up_model.dart';
import '../../../backend/model/common/common_success_model.dart';
import '../../../backend/services/api_services.dart';
import '../../../language/strings.dart';
import '../../../routes/routes.dart';
import '../../../widgets/others/congratulation_widget.dart';

class EmailOtpController extends GetxController {
  final emailOtpInputController = TextEditingController();
  bool hasError = false;
  RxString currentText = "".obs;
  RxInt secondsRemaining = 59.obs;
  RxInt minuteRemaining = 00.obs;
  RxBool enableResend = false.obs;
  Timer? timer;

  changeCurrentText(value) {
    currentText.value = value;
  }

  @override
  void onInit() {
    timerInit();
    super.onInit();
  }

  timerInit() {
    timer = Timer.periodic(const Duration(seconds: 1), (_) {
      if (minuteRemaining.value != 0) {
        secondsRemaining.value--;
        if (secondsRemaining.value == 0) {
          secondsRemaining.value = 59;
          minuteRemaining.value = 0;
        }
      } else if (minuteRemaining.value == 0 && secondsRemaining.value != 0) {
        secondsRemaining.value--;
      } else {
        enableResend.value = true;
      }
    });
  }


  final _isLoading = false.obs;

  bool get isLoading => _isLoading.value;
  late SignUpModel _registerModel;

  SignUpModel get registerModel => _registerModel;

  // mail Verify Code Process
  late CommonSuccessModel _mailVerifyCodeModel;

  CommonSuccessModel get mailVerifyCodeModel => _mailVerifyCodeModel;

  Future<CommonSuccessModel> mailVerifyCodeProcess(context) async {
    _isLoading.value = true;
    Map<String, dynamic> inputBody = {'code': emailOtpInputController.text};
    await ApiServices.verifyMailCodeApi(body: inputBody).then((value) {
      update();

      _mailVerifyCodeModel = value!;
      StatusScreen.show(
          context: context,
          subTitle: Strings.yourAccountHaveBeenCreated.tr,
          onPressed: () {
            _goToSavedUser();
          });
    }).catchError((onError) {
      _isLoading.value = false;
      log.e(onError);
    });
    _isLoading.value = false;
    update();
    return _mailVerifyCodeModel;
  }

  resendCode() {
    emailOtpInputController.clear();
    secondsRemaining.value = 59;
  }

  void _goToSavedUser() {
    LocalStorage.isLoginSuccess(isLoggedIn: true);
    LocalStorage.isLoggedIn();
    Get.toNamed(Routes.bottomNavBarScreen);
    update();
  }

  late CommonSuccessModel _mailCodeModel;

  CommonSuccessModel get mailCodeModel => _mailCodeModel;

  Future<CommonSuccessModel> resendVerifyCodeProcess() async {
    Map<String, dynamic> inputBody = {};
    await ApiServices.resendVerificationCodeApi(body: inputBody).then((value) {
      _mailCodeModel = value!;
      _goToEmailVerification();

      update();
    }).catchError((onError) {
      _isLoading.value = false;
      log.e(onError);
    });
    _isLoading.value = false;
    update();

    return _mailCodeModel;
  }

  _goToEmailVerification() {
    Get.toNamed(Routes.emailOtpScreen);
    update();
  }
}
