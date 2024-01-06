import 'package:stripcard/controller/auth/login/otp_reset_controller.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../../backend/model/common/common_success_model.dart';
import '../../../backend/services/api_services.dart';
import '../../../language/strings.dart';
import '../../../routes/routes.dart';
import '../../../widgets/others/congratulation_widget.dart';

class ResetPasswordController extends GetxController {
  final newPasswordController = TextEditingController();
  final confirmPasswordController = TextEditingController();
  final controller = Get.put(ResetOtpController());

  @override
  void dispose() {
    newPasswordController.dispose();
    confirmPasswordController.dispose();
    super.dispose();
  }

  final _isLoading = false.obs;

  bool get isLoading => _isLoading.value;

  late CommonSuccessModel _changePasswordModel;

  CommonSuccessModel get forgetPasswordChangePasswordModel =>
      _changePasswordModel;

  Future<CommonSuccessModel> changePasswordProcess(context) async {
    _isLoading.value = true;
    update();

    Map<String, dynamic> inputBody = {
      'code': controller.otpController.text,
      'password': newPasswordController.text,
      'password_confirmation': confirmPasswordController.text,
    };

    await ApiServices.changePasswordApi(body: inputBody).then((value) {
      _changePasswordModel = value!;

      controller.otpController.clear();
      newPasswordController.clear();
      confirmPasswordController.clear();

      update();

      _goToSuccessScreen(context);
    }).catchError((onError) {
      log.e(onError);
      _isLoading.value = false;
    });

    _isLoading.value = false;
    update();
    return _changePasswordModel;
  }

  void _goToSuccessScreen(context) {
    StatusScreen.show(
        context: context,
        subTitle: Strings.yourPasswordHasBeen.tr,
        onPressed: () {
          Get.offAllNamed(Routes.signInScreen);
        });
  }
}
