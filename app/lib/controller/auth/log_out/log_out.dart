import 'package:stripcard/utils/basic_screen_import.dart';

import '../../../backend/local_storage.dart';
import '../../../backend/model/common/common_success_model.dart';
import '../../../backend/services/api_services.dart';

class LogOutController extends GetxController {
  final _isLoading = false.obs;
  bool get isLoading => _isLoading.value;
  late CommonSuccessModel _logOutModel;

  CommonSuccessModel get logOutModel => _logOutModel;

  Future<CommonSuccessModel> logOutProcess() async {
    _isLoading.value = true;
    update();

    await ApiServices.logOutApi().then((value) {
      _logOutModel = value!;
      LocalStorage.logout();
      Get.offAllNamed(Routes.signInScreen);
      update();
    }).catchError((onError) {
      log.e(onError);
      _isLoading.value = false;
    });

    _isLoading.value = false;
    update();
    return _logOutModel;
  }
}
