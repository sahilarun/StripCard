import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../../backend/local_storage.dart';
import '../../../backend/model/auth/login_model.dart';
import '../../../backend/model/common/common_success_model.dart';
import '../../../backend/services/api_services.dart';
import '../../../routes/routes.dart';

class SignInController extends GetxController {
  final emailAddressController = TextEditingController();
  final forgetEmailAddressController = TextEditingController();
  final otpPhoneController = TextEditingController();
  final phoneController = TextEditingController();
  final passwordController = TextEditingController();

  @override
  void dispose() {
    emailAddressController.dispose();
    phoneController.dispose();
    passwordController.dispose();
    forgetEmailAddressController.dispose();
    otpPhoneController.dispose();

    super.dispose();
  }

  final _isLoading = false.obs;

  bool get isLoading => _isLoading.value;

  final _isForgetPasswordLoading = false.obs;

  bool get isForgetPasswordLoading => _isForgetPasswordLoading.value;

  late LoginModel _loginModel;

  LoginModel get loginModel => _loginModel;

  // Login process function
  Future<LoginModel> loginProcess() async {
    _isLoading.value = true;
    update();

    Map<String, dynamic> inputBody = {
      'email': emailAddressController.text,
      'password': passwordController.text,
    };
    // calling login api from api service
    await ApiServices.loginApi(body: inputBody).then((value) {
      _loginModel = value!;
      if (_loginModel.data.user.emailVerified == 0) {
        _goToEmailVerification(_loginModel);
      } else {
        _goToSavedUser(_loginModel);
      }
      update();
    }).catchError((onError) {
      log.e(onError);
    });

    _isLoading.value = false;
    update();
    return _loginModel;
  }

// Forget Password Email Process
  late CommonSuccessModel _forgetPasswordModel;

  CommonSuccessModel get forgetPasswordModel => _forgetPasswordModel;

  Future<CommonSuccessModel> forgetPasswordEmailProcess() async {
    _isForgetPasswordLoading.value = true;
    update();

    Map<String, dynamic> inputBody = {
      'email': forgetEmailAddressController.text,
    };
    await ApiServices.forgetPasswordApi(body: inputBody).then((value) {
      _forgetPasswordModel = value!;
      Get.toNamed(Routes.resetOtpScreen);
      update();
      emailAddressController.clear();
    }).catchError((onError) {
      log.e(onError);
      _isForgetPasswordLoading.value = false;
    });

    _isForgetPasswordLoading.value = false;
    update();
    return _forgetPasswordModel;
  }

  void onPressedSignUP() {
    Get.toNamed(Routes.registrationScreen);
  }

  void _goToSavedUser(LoginModel loginModel) {
    LocalStorage.saveToken(token: loginModel.data.token.toString());
    LocalStorage.isLoginSuccess(isLoggedIn: true);

    LocalStorage.isLoggedIn();
    update();
    _goToDashboardScreen();
  }

  _goToDashboardScreen() {
    Get.offAndToNamed(Routes.bottomNavBarScreen);
  }

  void _goToEmailVerification(LoginModel loginModel) {
    LocalStorage.saveToken(token: loginModel.data.token.toString());
    LocalStorage.saveEmail(email: emailAddressController.text);

    Get.toNamed(Routes.emailOtpScreen);
  }
}
