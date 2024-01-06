import 'package:stripcard/custom_assets/assets.gen.dart';
import 'package:stripcard/data/onboard_data.dart';
import 'package:stripcard/routes/routes.dart';
import 'package:stripcard/utils/custom_color.dart';
import 'package:stripcard/utils/dimensions.dart';
import 'package:stripcard/views/others/custom_image_widget.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';

import '../../backend/local_storage.dart';

class OnBoardController extends GetxController {
  var selectedIndex = 0.obs;
  var pageController = PageController();

  bool get isLastPage => selectedIndex.value == onboardData.length;

  bool get isFirstPage => selectedIndex.value == 0;

  // bool get isSecondPage => selectedIndex.value == 1;

  void nextPage() {
    if (isLastPage) {
    } else {
      pageController.nextPage(
        duration: 300.milliseconds,
        curve: Curves.ease,
      );
    }
  }

  void backPage() {
    pageController.previousPage(
      duration: 300.milliseconds,
      curve: Curves.ease,
    );
  }

  pageNavigate() {
    LocalStorage.saveOnboardDoneOrNot(isOnBoardDone: true);
    Get.offAllNamed(Routes.signInScreen);
  }

  AnimatedContainer buildDot({int? index}) {
    return AnimatedContainer(
      duration: const Duration(milliseconds: 200),
      margin: EdgeInsets.symmetric(horizontal: 5.w),
      height: 10,
      width: 10,
      decoration: BoxDecoration(
        shape: BoxShape.circle,
        color: index == selectedIndex.value
            ? CustomColor.whiteColor
            : CustomColor.whiteColor.withOpacity(0.3),
      ),
    );
  }

  AnimatedContainer buildArrow({int? index}) {
    return AnimatedContainer(
      duration: const Duration(milliseconds: 200),
      margin: EdgeInsets.symmetric(horizontal: 2.w),
      child: CustomImageWidget(
        height: 11,
        width: 5,
        color: index == selectedIndex.value
            ? CustomColor.whiteColor
            : CustomColor.whiteColor.withOpacity(0.3),
        path: Assets.icon.rightArrow,
      ),
    );
  }

  dotWidget() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.center,
      children: List.generate(
        onboardData.length,
        (index) => buildDot(index: index),
      ),
    );
  }

  arrowWidget() {
    return InkWell(
      onTap: () {
        isFirstPage || isLastPage ? nextPage() : pageNavigate();
      },
      child: Container(
        width: Dimensions.widthSize * 3,
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: List.generate(
            onboardData.length,
            (index) => buildArrow(index: index),
          ),
        ),
      ),
    );
  }
}
