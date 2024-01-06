import 'dart:async';
import 'package:stripcard/utils/basic_screen_import.dart';
import 'package:connectivity_plus/connectivity_plus.dart';
import 'package:flutter/foundation.dart';

class NetworkController extends GetxController {
  final Connectivity _connectivity = Connectivity();
  late ConnectivityResult connectivityResult;
  late StreamSubscription<ConnectivityResult> _streamSubscription;

  @override
  void onInit() async {
    super.onInit();
    _initConnectivity();
    _streamSubscription =
        _connectivity.onConnectivityChanged.listen(_updateConnectionStatus);
  }

  Future<void> _initConnectivity() async {
    connectivityResult = await _connectivity.checkConnectivity();
  }

  void _updateConnectionStatus(ConnectivityResult connectivityResult) {
    if (kDebugMode) print("STATUS : $connectivityResult");

    if (connectivityResult == ConnectivityResult.none) {
      Get.dialog(
          barrierDismissible: false,
          barrierColor: Get.isDarkMode
              ? CustomColor.primaryDarkScaffoldBackgroundColor
              : CustomColor.primaryLightScaffoldBackgroundColor,
          WillPopScope(
            onWillPop: () async => false,
            child: Dialog(
                backgroundColor: Colors.transparent,
                elevation: 0,
                child: Column(
                  mainAxisAlignment: mainCenter,
                  children: [
                    Text(
                      'PLEASE CONNECT TO THE INTERNET',
                      style: TextStyle(
                        color: CustomColor.primaryLightColor,
                        fontSize: 14,
                      ),
                    ),
                    verticalSpace(Dimensions.heightSize),
                    Icon(
                      Icons.wifi_off,
                      color: CustomColor.primaryLightColor,
                      size: Dimensions.iconSizeLarge * 1.5,
                    ),
                  ],
                )),
          ));
    } else {
      if (Get.isDialogOpen!) {
        Get.back();
      }
    }
  }

  @override
  void onClose() {
    _streamSubscription.cancel();
  }
}
