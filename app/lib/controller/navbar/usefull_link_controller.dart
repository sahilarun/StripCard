import '../../backend/model/others/usefull_link_model.dart';
import '../../backend/services/api_services.dart';
import '../../utils/basic_screen_import.dart';

class UseFullLinkController extends GetxController {
  RxString privacyPolicy = ''.obs;


  @override
  void onInit() {
    getUseFullLinks();
    super.onInit();
  }

  final _isLoading = false.obs;
  bool get isLoading => _isLoading.value;

  late UseFullLinkModel _useFullLinkModel;
  UseFullLinkModel get useFullLinkModel => _useFullLinkModel;

  Future<UseFullLinkModel> getUseFullLinks() async {
    _isLoading.value = true;
    update();

    await ApiServices.useFullLinkApi().then((value) {
      _useFullLinkModel = value!;
      final data = _useFullLinkModel.data;
      for (int i = 0; i < data.policyPages.length; i++) {
        if (data.policyPages[i].slug.contains('privacy-policy')) {
          privacyPolicy.value = data.policyPages[i].link;
          debugPrint(privacyPolicy.value);
        }
      }
      update();

      _isLoading.value = false;
      update();
    }).catchError((onError) {
      log.e(onError);
      _isLoading.value = false;
    });

    _isLoading.value = false;
    update();
    return _useFullLinkModel;
  }
}
