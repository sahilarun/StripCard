// ignore_for_file: must_be_immutable

import 'package:flutter_inappwebview/flutter_inappwebview.dart';
import 'package:stripcard/utils/basic_widget_import.dart';
import '../../../backend/utils/custom_loading_api.dart';
import '../../../widgets/appbar/appbar_widget.dart';


class WebViewScreen extends StatelessWidget {
  WebViewScreen({super.key, required this.title, required this.url});
  final String title, url;
  late InAppWebViewController webViewController;
  final ValueNotifier<bool> isLoading = ValueNotifier<bool>(true);
  @override
  Widget build(BuildContext context) {
    return WillPopScope(
      onWillPop: () async {
    Get.close(1);
        return false;
      },child:Scaffold(
      appBar: AppBarWidget(
        text: title,
        onTap: () {
          Get.close(1);
        },
      ),
      body: _bodyWidget(context),
    ));
  }

  _bodyWidget(BuildContext context) {
        String paymentUrl = url;
    return Stack(
      children: [
        InAppWebView(
          initialUrlRequest: URLRequest(url: Uri.parse(paymentUrl)),
          onWebViewCreated: (controller) {
            webViewController = controller;
            controller.addJavaScriptHandler(
              handlerName: 'jsHandler',
              callback: (args) {
                // Handle JavaScript messages from WebView
              },
            );
          },
          onLoadStart: (controller, url) {
            isLoading.value = true;
          },
          onLoadStop: (controller, url) {
            isLoading.value = false;
          },
          // ... other callbacks ...
        ),
        ValueListenableBuilder<bool>(
          valueListenable: isLoading,
          builder: (context, isLoading, _) {
            return isLoading
                ? const Center(child: CustomLoadingAPI(color: CustomColor.primaryLightColor,))
                : const SizedBox.shrink();
          },
        ),
      ],
    );
  }
}
