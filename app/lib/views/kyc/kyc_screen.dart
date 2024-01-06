import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../../../utils/responsive_layout.dart';
import '../../controller/drawer/kyc_controller.dart';
import 'kyc_mobile_screen_layout.dart';


class KycScreen extends StatelessWidget {
  KycScreen({Key? key}) : super(key: key);
  final controller = Get.put(KycController());

  @override
  Widget build(BuildContext context) {
    // mobile screen layout
    return ResponsiveLayout(
      mobileScaffold: SafeArea(
        child: KycMobileScreenLayout(
          controller: controller,
        ),
      ),
    );
  }
}
