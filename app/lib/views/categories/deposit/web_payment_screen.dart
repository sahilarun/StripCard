import 'package:stripcard/controller/navbar/deposit/deposit_controller.dart';
import 'package:stripcard/language/strings.dart';
import 'package:flutter/material.dart';
import 'package:flutter_inappwebview/flutter_inappwebview.dart';
import 'package:get/get.dart';

import '../../../backend/utils/custom_loading_api.dart';
import '../../../routes/routes.dart';
import '../../../utils/custom_color.dart';
import '../../../widgets/appbar/appbar_widget.dart';
import '../../../widgets/others/congratulation_widget.dart';

class WebPaymentScreen extends StatelessWidget {
  WebPaymentScreen({super.key,});

  final controller = Get.put(DepositController());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBarWidget(
        text: Strings.paypalPayment.tr,
        onTap: () {
          Get.offAllNamed(Routes.bottomNavBarScreen);
        },
        actions: [
          IconButton(
              onPressed: () {
                Get.offAllNamed(Routes.bottomNavBarScreen);
              },
              icon: Icon(
                Icons.home,
                color: Get.isDarkMode
                    ? CustomColor.whiteColor
                    : CustomColor.whiteColor,
              ))
        ],
      ),
      body: Obx(
        () => controller.isLoading
            ? CustomLoadingAPI(
                color: CustomColor.primaryLightColor,
              )
            : _bodyWidget(context),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    var paymentUrl = '';
    final data = controller.automaticPaymentPaypalGatewayModel.data.url;
    for (int i = 0; i < data.length; i++) {
      if (data[i].rel.contains('approve')) {
        paymentUrl = data[i].href;
      }
    }
    return InAppWebView(
      initialUrlRequest: URLRequest(url: Uri.parse(paymentUrl)),
      onWebViewCreated: (InAppWebViewController controller) {},
      onProgressChanged: (InAppWebViewController controller, int progress) {},
      onLoadStop: (controller, url) {
        // Handle page load stop, e.g., hide loading indicator

        if (url.toString().contains('success/response')) {
          StatusScreen.show(
              context: context,
              subTitle: Strings.yourMoneyAddedSucces.tr,
              onPressed: () {
                Get.offAllNamed(Routes.bottomNavBarScreen);
              });
        }
      },
    );
  }
}
