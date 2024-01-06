import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/controller/app_settings/app_settings_controller.dart';
import 'package:stripcard/utils/basic_screen_import.dart';
import 'package:cached_network_image/cached_network_image.dart';

class SplashScreen extends StatelessWidget {
  SplashScreen({Key? key}) : super(key: key);
  final controller = Get.put(AppSettingsController());
  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        backgroundColor: Theme.of(context).scaffoldBackgroundColor,
        body: Obx(
          () => controller.isLoading
              ? CustomLoadingAPI(color: CustomColor.primaryLightColor)
              : Center(
                  child: CachedNetworkImage(
                    imageUrl: controller.splashImagePath.value,
                    fit: BoxFit.fill,
                    placeholder: (context, url) => Text(''),
                    errorWidget: (context, url, error) => Text(''),
                  ),
                ),
        ),
      ),
    );
  }
}
