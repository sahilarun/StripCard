import 'dart:async';

import 'package:get/get.dart';
import '../../backend/local_storage.dart';
import '../../routes/routes.dart';

class SplashController extends GetxController {
  @override
  void onReady() {
    super.onReady();
    _goToScreen();
  }

  _goToScreen() async {
    Timer(const Duration(seconds: 5), () {
      LocalStorage.isLoggedIn()
          ? Get.offAndToNamed(Routes.bottomNavBarScreen)
          : Get.offAndToNamed(
              LocalStorage.isOnBoardDone()
                  ? Routes.signInScreen
                  : Routes.onboardScreen,
            );
    });
  }
}
