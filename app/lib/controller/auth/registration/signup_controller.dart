import 'package:stripcard/backend/local_storage.dart';
import 'package:stripcard/routes/routes.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../../../backend/model/auth/sign_up_model.dart';
import '../../../backend/services/api_services.dart';

class RegistrationController extends GetxController {
  final firstNameController = TextEditingController();
  final lastNameController = TextEditingController();
  final emailAddressController = TextEditingController();
  final passwordController = TextEditingController();

  RxBool termsAndCondition = false.obs;
  RxBool isSelected = true.obs;
  final _isLoading = false.obs;
  bool get isLoading => _isLoading.value;

  late SignUpModel _registerModel;

  SignUpModel get registerModel => _registerModel;

  // Register process function
  Future<SignUpModel> signUpProcess() async {
    _isLoading.value = true;
    update();

    Map<String, String> inputBody = {
      'firstname': firstNameController.text,
      'lastname': lastNameController.text,
      'email': emailAddressController.text,
      'password': passwordController.text,
      'agree': 'on',
    };

    await ApiServices.registerApi(body: inputBody).then((value) {
      _registerModel = value!;
      LocalStorage.saveToken(token: _registerModel.data.token.toString());
      LocalStorage.saveEmail(email: emailAddressController.text);
      onTapContinue();
      update();
    }).catchError((onError) {
      _isLoading.value = false;
      log.e(onError);
    });

    _isLoading.value = false;
    update();
    return _registerModel;
  }

  void onTapContinue() {
    Get.toNamed(Routes.emailOtpScreen);
  }

  void onPressedSignIn() {
    Get.toNamed(Routes.signInScreen);
  }
}
