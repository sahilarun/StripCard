import '../../../backend/model/common/common_success_model.dart';
import '../../../backend/services/api_services.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../widgets/others/congratulation_widget.dart';

class MoneyTransferController extends GetxController {
  final receiverEmailController = TextEditingController();
  final amountController = TextEditingController();

  final _isLoading = false.obs;
  bool get isLoading => _isLoading.value;

  ///  >>>>>> Start check user  process

  late CommonSuccessModel _transferCheckModel;
  CommonSuccessModel get transferCheckModel => _transferCheckModel;

  Future<CommonSuccessModel> transferCheckUserProcess() async {
    _isLoading.value = true;
    update();
    Map<String, dynamic> inputBody = {
      "email": receiverEmailController.text,
    };
    await ApiServices.transferMoneyCheckUserApi(body: inputBody).then((value) {
      _transferCheckModel = value!;
      update();
      Get.toNamed(Routes.moneyTransferPreviewScreen);
      update();
    }).catchError((onError) {
      log.e(onError);
      update();
    });

    _isLoading.value = false;
    update();
    return _transferCheckModel;
  }

  //transfer confirm
  final _isConfirmLoading = false.obs;
  bool get isConfirmLoading => _isConfirmLoading.value;
  late CommonSuccessModel _transferConfirmModel;
  CommonSuccessModel get buyCardModel => _transferConfirmModel;

  Future<CommonSuccessModel> transferMoneyConfirmProcess(context) async {
    _isConfirmLoading.value = true;
    update();
    Map<String, dynamic> inputBody = {
      "email": receiverEmailController.text,
      "amount": amountController.text,
    };
    await ApiServices.transferMoneyConfirmApi(body: inputBody).then((value) {
      _transferConfirmModel = value!;
      update();

      StatusScreen.show(
        context: context,
        subTitle: Strings.transferSuccessText.tr,
        onPressed: () {
          Get.offAllNamed(Routes.bottomNavBarScreen);
        },
      );
      update();
    }).catchError((onError) {
      log.e(onError);
      update();
    });

    _isConfirmLoading.value = false;
    update();
    return _transferConfirmModel;
  }
}
