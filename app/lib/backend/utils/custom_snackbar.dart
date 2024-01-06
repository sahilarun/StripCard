import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../../language/strings.dart';
import '../../utils/custom_color.dart';
import '../../utils/dimensions.dart';

class CustomSnackBar {
  static success(String message) {
    return Get.snackbar(Strings.successSnack, message,
        margin: EdgeInsets.symmetric(
            horizontal: Dimensions.marginSizeHorizontal * 0.5,
            vertical: Dimensions.marginSizeVertical * 0.5),
        backgroundColor: CustomColor.thirdLightTextColor,
        colorText: CustomColor.whiteColor,
        leftBarIndicatorColor: CustomColor.greenColor,
        progressIndicatorBackgroundColor: Colors.red,
        isDismissible: true,
        animationDuration: const Duration(seconds: 1),
        snackPosition: SnackPosition.BOTTOM,
        borderRadius: 5.0,
        mainButton: TextButton(
            onPressed: () {
              Get.back();
            },
            child: const Text(Strings.dismiss)),
        // boxShadows: BoxShadow()
        icon: const Icon(
          Icons.check_circle_rounded,
          color: CustomColor.greenColor,
        ));
  }

  static error(String message) {
    return Get.snackbar(Strings.alert, message,
        margin: EdgeInsets.symmetric(
            horizontal: Dimensions.marginSizeHorizontal * 0.5,
            vertical: Dimensions.marginSizeVertical * 0.5),
        backgroundColor: CustomColor.thirdLightTextColor,
        colorText: CustomColor.whiteColor,
        leftBarIndicatorColor: CustomColor.redColor,
        progressIndicatorBackgroundColor: CustomColor.redColor,
        isDismissible: true,
        animationDuration: const Duration(seconds: 1),
        snackPosition: SnackPosition.BOTTOM,
        borderRadius: 5.0,
        mainButton: TextButton(
            onPressed: () {
              Get.back();
            },
            child: const Text(Strings.dismiss)),
        // boxShadows: BoxShadow()
        icon: const Icon(
          Icons.warning,
          color: CustomColor.redColor,
        ));
  }
}
