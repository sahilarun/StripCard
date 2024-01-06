import 'package:carousel_slider/carousel_slider.dart';

import '../../backend/local_storage.dart';
import '../../backend/model/dashboard/dashboard_model.dart';
import '../../backend/services/api_services.dart';
import '../../utils/basic_screen_import.dart';

class DashBoardController extends GetxController {
  final CarouselController carouselController = CarouselController();
  final firstNameController = TextEditingController();
  final lastNameController = TextEditingController();
  final emailController = TextEditingController();
  RxInt current = 0.obs;

  @override
  void onInit() {
    getDashboardData();
    super.onInit();
  }

  final _isLoading = false.obs;
  bool get isLoading => _isLoading.value;

  late DashBoardModel _dashBoardModel;
  DashBoardModel get dashBoardModel => _dashBoardModel;

  Future<DashBoardModel> getDashboardData() async {
    _isLoading.value = true;
    update();

    await ApiServices.dashboardApi().then((value) {
      _dashBoardModel = value!;
      final data = _dashBoardModel.data.user;
      firstNameController.text = data.firstname;
      lastNameController.text = data.lastname;
      emailController.text = data.email;

      LocalStorage.saveBaseCurrency(currency: _dashBoardModel.data.baseCurr);
      LocalStorage.saveKycStatus(status: _dashBoardModel.data.user.kycVerified);
      update();

      _isLoading.value = false;
      update();
    }).catchError((onError) {
      log.e(onError);
      _isLoading.value = false;
    });

    _isLoading.value = false;
    update();
    return _dashBoardModel;
  }
}
