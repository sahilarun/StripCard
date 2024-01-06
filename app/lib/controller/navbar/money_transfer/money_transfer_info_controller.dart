import '../../../backend/model/transfer_money/transfer_money_info_model.dart';
import '../../../backend/services/api_services.dart';
import '../../../utils/basic_screen_import.dart';

class MoneyTransferInfoController extends GetxController {
  @override
  void onInit() {
    getTransferMoneyData();

    super.onInit();
  }

  final _isLoading = false.obs;
  bool get isLoading => _isLoading.value;

  late TransferMoneyInfoModel _transferMoneyInfoModel;
  TransferMoneyInfoModel get transferMoneyInfoModel => _transferMoneyInfoModel;

  Future<TransferMoneyInfoModel> getTransferMoneyData() async {
    _isLoading.value = true;
    update();

    await ApiServices.transferMoneyInfoApi().then((value) {
      _transferMoneyInfoModel = value!;

      update();
    }).catchError((onError) {
      log.e(onError);
    });

    _isLoading.value = false;
    update();
    return _transferMoneyInfoModel;
  }
}
