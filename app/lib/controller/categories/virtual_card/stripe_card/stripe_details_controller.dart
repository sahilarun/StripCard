
import '../../../../backend/model/common/common_success_model.dart';
import '../../../../backend/model/virtual_card/stripe_models/stripe_card_details_model.dart';
import '../../../../backend/model/virtual_card/stripe_models/stripe_card_sensitive_model.dart';
import '../../../../backend/services/api_services.dart';
import '../../../../utils/basic_screen_import.dart';
import 'stripe_card_controller.dart';

class StripeCardDetailsController extends GetxController {
  RxBool isSelected = false.obs;
  RxBool isShowSensitive = false.obs;
  RxString cardPlan = "".obs;
  RxString cardCVC = "".obs;
  final stripeController = Get.put(StripeCardController());
  @override
  void onInit() {
    getCardDetailsData();
    super.onInit();
  }

  ///>>>>>>>>>> get details data
  final _isLoading = false.obs;
  bool get isLoading => _isLoading.value;

  final _isCardStatusLoading = false.obs;
  bool get isCardStatusLoading => _isCardStatusLoading.value;
  // Card Details Method
  late StripeCardDetailsModel _stripeCardDetailsModel;
  StripeCardDetailsModel get cardDetailsModel => _stripeCardDetailsModel;

  Future<StripeCardDetailsModel> getCardDetailsData() async {
    _isLoading.value = true;
    update();

    await ApiServices.stripeCardDetailsApi(stripeController.cardId.value)
        .then((value) {
      _stripeCardDetailsModel = value!;

      if (_stripeCardDetailsModel.data.cardDetails.status == true) {
        isSelected.value = true;
      } else {
        isSelected.value = false;
      }

      print(isSelected.value);
      update();
    }).catchError((onError) {
      log.e(onError);
      _isLoading.value = false;
      update();
    });

    _isLoading.value = false;
    update();
    return _stripeCardDetailsModel;
  }

  /// >>>>>>>>>>>> active card
  late CommonSuccessModel _cardActiveModel;
  CommonSuccessModel get cardActiveModel => _cardActiveModel;

  Future<CommonSuccessModel> cardActiveApi() async {
    _isCardStatusLoading.value = true;
    update();
    Map<String, dynamic> inputBody = {
      'card_id': stripeController.cardId.value,
    };
    await ApiServices.stripeActiveApi(body: inputBody).then((value) {
      _cardActiveModel = value!;
      update();
      debugPrint('Card Active');
      getCardDetailsData();
    }).catchError((onError) {
      log.e(onError);
      _isCardStatusLoading.value = false;
      update();
    });

    _isCardStatusLoading.value = false;
    update();
    return _cardActiveModel;
  }

  ///>>>>>>>>>>>>>  card inactive process
  late CommonSuccessModel _cardInactiveModel;
  CommonSuccessModel get cardInactiveModel => _cardInactiveModel;

  Future<CommonSuccessModel> cardInactiveApi() async {
    _isCardStatusLoading.value = true;
    update();
    Map<String, dynamic> inputBody = {
      'card_id': stripeController.cardId.value,
    };
    await ApiServices.stripeInactiveApi(body: inputBody).then((value) {
      _cardInactiveModel = value!;
      update();
      debugPrint('Card Inactive');
      getCardDetailsData();
    }).catchError((onError) {
      log.e(onError);
      _isCardStatusLoading.value = false;
      update();
    });

    _isCardStatusLoading.value = false;
    update();
    return _cardInactiveModel;
  }

  _cardToggle() {
    if (_stripeCardDetailsModel.data.cardDetails.status == true) {
      cardInactiveApi();
    } else {
      cardActiveApi();
    }
  }

  get cardToggle => _cardToggle();

  ///>>>>>>> card reveal show

  final _isSensitiveLoading = false.obs;
  bool get isSensitiveLoading => _isSensitiveLoading.value;
  late StripeSensitiveModel _revealShowModel;
  StripeSensitiveModel get revealShowModel => _revealShowModel;

  Future<StripeSensitiveModel> revealShowProcess() async {
    _isSensitiveLoading.value = true;
    update();
    Map<String, dynamic> inputBody = {
      'card_id': stripeController.cardId.value,
    };
    await ApiServices.stripeSensitiveApi(body: inputBody).then((value) {
      _revealShowModel = value!;
      update();

      cardPlan.value = revealShowModel.data.sensitiveData.number;
      cardCVC.value = revealShowModel.data.sensitiveData.cvc;
    }).catchError((onError) {
      log.e(onError);
      _isSensitiveLoading.value = false;
      update();
    });

    _isSensitiveLoading.value = false;
    update();
    return _revealShowModel;
  }
}
