import 'dart:async';
import 'dart:math';

import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../../backend/model/common/common_success_model.dart';
import '../../../backend/services/api_services.dart';
import '../../../routes/routes.dart';
import 'signin_controller.dart';

class ResetOtpController extends GetxController {
  final otpController = TextEditingController();
  final controller = Get.put(SignInController());
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

  late CommonSuccessModel _forgetPasswordVerifyEmailModel;

  CommonSuccessModel get forgetPasswordVerifyEmailModel =>
      _forgetPasswordVerifyEmailModel;

  Future<CommonSuccessModel> forgetPasswordVerifyEmailProcess() async {
    _isLoading.value = true;
    update();

    Map<String, dynamic> inputBody = {
      'code': otpController.text,
      'email': controller.forgetEmailAddressController.text
    };

    await ApiServices.forgetPasswordVerifyEmailApi(body: inputBody)
        .then((value) {
      _forgetPasswordVerifyEmailModel = value!;
      onPressedSignInOtpSubmit();
      update();
    }).catchError((onError) {
      log.e(onError);
    });

    _isLoading.value = false;
    update();
    return _forgetPasswordVerifyEmailModel;
  }

  late CommonSuccessModel _resetCodeModel;

  CommonSuccessModel get resetCodeModel => _resetCodeModel;

  Future<CommonSuccessModel> resendResetCodeProcess() async {
    Map<String, dynamic> inputBody = {
      'email': controller.forgetEmailAddressController.text
    };
    await ApiServices.passwordResetCodeApi(body: inputBody).then((value) {
      update();

      _resetCodeModel = value!;
    }).catchError((onError) {
      _isLoading.value = false;
      log.e(onError);
    });
    _isLoading.value = false;
    update();

    return _resetCodeModel;
  }

  resendCode() {
    otpController.clear();
    secondsRemaining.value = 59;
 
  }

  void onPressedSignInOtpSubmit() {
    Get.toNamed(Routes.resetPasswordScreen);
  }

  final emailMaskRegExp = RegExp('^(.)(.*?)([^@]?)(?=@[^@]+\$)');

  String maskEmail(String input, [int minFill = 4, String fillChar = '*']) {
    minFill == 4;
    fillChar == '*';
    return input.replaceFirstMapped(emailMaskRegExp, (m) {
      var start = m.group(1);
      var middle = fillChar * max(minFill, m.group(2)!.length);
      var end = m.groupCount >= 3 ? m.group(3) : start;
      return start! + middle + end!;
    });
  }
}
