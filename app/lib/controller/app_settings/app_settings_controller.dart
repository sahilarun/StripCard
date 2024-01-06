import 'package:stripcard/backend/local_storage.dart';
import 'package:stripcard/utils/basic_screen_import.dart';

import '../../backend/model/onboard/app_settings_model.dart';
import '../../backend/services/api_endpoint.dart';
import '../../backend/services/api_services.dart';

class AppSettingsController extends GetxController {
  final List<OnboardScreen> onboardScreen = [];

  RxString splashImagePath = ''.obs;
  @override
  void onInit() {
    getSplashAndOnboardData();
    super.onInit();
  }

  final _isLoading = false.obs;
  bool get isLoading => _isLoading.value;

  late AppSettingsModel _appSettingsModel;
  AppSettingsModel get appSettingsModel => _appSettingsModel;

  Future<AppSettingsModel> getSplashAndOnboardData() async {
    _isLoading.value = true;
    update();

    await ApiServices.appSettingsApi().then((value) {
      _appSettingsModel = value!;
      splashImagePath.value =
          "${ApiEndpoint.mainDomain}/${_appSettingsModel.data.imagePath}/${_appSettingsModel.data.splashScreen.splashScreenImage}";

      LocalStorage.saveSplashImage(
          image:
              "${ApiEndpoint.mainDomain}/${_appSettingsModel.data.imagePath}/${_appSettingsModel.data.splashScreen.splashScreenImage}");

      LocalStorage.saveBasicImage(
          image:
              "${ApiEndpoint.mainDomain}/${_appSettingsModel.data.logoImagePath}/${_appSettingsModel.data.allLogo.siteLogo}");

      print(LocalStorage.getSplashImage());

      _appSettingsModel.data.onboardScreen.forEach(
        (element) {
          onboardScreen.add(
            OnboardScreen(
              id: element.id,
              title: element.title,
              subTitle: element.subTitle,
              image: element.image,
              status: element.status,
              createdAt: element.createdAt,
              updatedAt: element.updatedAt,
            ),
          );
        },
      );

      //save url link
      // var data = _appSettingsModel.data.p;
      // LocalStorage.savePrivacyPolicyLink(link: data.privacyPolicy);

      update();
      _isLoading.value = false;
      update();
    }).catchError((onError) {
      log.e(onError);
      _isLoading.value = false;
    });
    _isLoading.value = false;
    update();
    return _appSettingsModel;
  }
}
