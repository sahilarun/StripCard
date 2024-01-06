import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../../backend/model/common/common_success_model.dart';
import '../../backend/services/api_services.dart';

class PasswordController extends GetxController {
  final oldPasswordController = TextEditingController();
  final newPasswordController = TextEditingController();
  final confirmPasswordController = TextEditingController();

  final _isLoading = false.obs;

  bool get isLoading => _isLoading.value;

  late CommonSuccessModel _updatePasswordModel;

  CommonSuccessModel get updatePasswordModel => _updatePasswordModel;

  Future<CommonSuccessModel> updatePasswordProcess() async {
    _isLoading.value = true;
    update();

    Map<String, dynamic> inputBody = {
      'current_password': oldPasswordController.text,
      'password': newPasswordController.text,
      'password_confirmation': confirmPasswordController.text,
    };

    await ApiServices.updatePasswordApi(body: inputBody).then((value) {
      _updatePasswordModel = value!;
      oldPasswordController.clear();
      newPasswordController.clear();
      confirmPasswordController.clear();
      update();
    }).catchError((onError) {
      log.e(onError);
    });

    _isLoading.value = false;
    update();
    return _updatePasswordModel;
  }


}
