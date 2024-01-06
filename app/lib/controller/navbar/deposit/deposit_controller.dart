import 'package:flip_card/flip_card_controller.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../../backend/model/add_money/add_money_info_model.dart';
import '../../../backend/model/add_money/automatic_flutterwave.dart';
import '../../../backend/model/add_money/automatic_paypal_getway.dart';
import '../../../backend/model/add_money/automatic_razorpay_model.dart';
import '../../../backend/model/add_money/automatic_ssclcommerz_model.dart';
import '../../../backend/model/add_money/automatic_stripe_getway_model.dart';
import '../../../backend/services/api_services.dart';
import '../../../routes/routes.dart';
import 'manual_gateway_controller.dart';

class DepositController extends GetxController {
  final amountController = TextEditingController();
  final depositMethod = TextEditingController();

  final cardNumberController = TextEditingController();
  final cardExpiryController = TextEditingController();
  final cardCVCController = TextEditingController();

  final cardHolderNameController = TextEditingController();
  final cardExpiryDateController = TextEditingController();
  final cardCvvController = TextEditingController();

  final flipCardController = FlipCardController();
  RxDouble amount = 0.0.obs;
  RxString baseCurrency = "".obs;
  RxInt baseCurrencyRate = 1.obs;
  RxString selectedCurrencyAlias = "".obs;
  RxString selectedCurrencyName = "Select Method".obs;
  RxString selectedCurrencyType = "".obs;
  RxString selectedGatewaySlug = "".obs;
  RxString gatewayTrx = "".obs;
  RxInt selectedCurrencyId = 0.obs;
  RxDouble fee = 0.0.obs;
  RxDouble limitMin = 0.0.obs;
  RxDouble limitMax = 0.0.obs;

  RxDouble percentCharge = 0.0.obs;
  RxDouble rate = 0.0.obs;
  RxString code = "".obs;
  List<int> indexList = [];
  List<Currency> currencyList = [];

  final manualPaymentController = Get.put(ManualPaymentController());
  @override
  void onInit() {
    getAddMoneyInfo();
    super.onInit();
  }

  late AddMoneyInfoModel _addMoneyInfoModel;
  AddMoneyInfoModel get addMoneyInfoModel => _addMoneyInfoModel;

  final _isLoading = false.obs;
  bool get isLoading => _isLoading.value;
  final _isPaypalLoading = false.obs;
  bool get isPaypalLoading => _isPaypalLoading.value;
  final _isStripeLoading = false.obs;
  bool get isStripeLoading => _isStripeLoading.value;

  Future<AddMoneyInfoModel> getAddMoneyInfo() async {
    _isLoading.value = true;
    update();

    await ApiServices.addMoneyInfoApi().then((value) {
      _addMoneyInfoModel = value!;

      _addMoneyInfoModel.data.gateways.forEach((gateways) {
        gateways.currencies.forEach((currency) {
          currencyList.add(
            Currency(
              id: currency.id,
              paymentGatewayId: currency.paymentGatewayId,
              name: currency.name,
              alias: currency.alias,
              currencyCode: currency.currencyCode,
              currencySymbol: currency.currencySymbol,
              minLimit: currency.minLimit,
              maxLimit: currency.maxLimit,
              percentCharge: currency.percentCharge,
              fixedCharge: currency.fixedCharge,
              rate: currency.rate,
              createdAt: currency.createdAt,
              updatedAt: currency.updatedAt,
              type: currency.type,
              image: currency.image,
            ),
          );
        });
      });
      Currency currency =
          _addMoneyInfoModel.data.gateways.first.currencies.first;
      Gateway gateway = _addMoneyInfoModel.data.gateways.first;

      selectedCurrencyAlias.value = currency.alias;
      selectedCurrencyType.value = currency.type.toString();
      selectedGatewaySlug.value = gateway.slug.toString();
      selectedCurrencyId.value = currency.id;
      selectedCurrencyName.value = currency.name;

      fee.value = currency.fixedCharge.toDouble();
      limitMin.value = currency.minLimit.toDouble();
      limitMax.value = currency.maxLimit.toDouble();
      percentCharge.value = currency.percentCharge.toDouble();
      rate.value = currency.rate;
      code.value = currency.currencyCode;

      //Base Currency
      baseCurrency.value = _addMoneyInfoModel.data.baseCurr;
      baseCurrencyRate.value = _addMoneyInfoModel.data.baseCurrRate;

      update();
    }).catchError((onError) {
      log.e(onError);
      _isLoading.value = false;
      update();
    });

    _isLoading.value = false;
    update();
    return _addMoneyInfoModel;
  }

  late AutomaticPaymentPaypalGatewayModel _automaticPaymentPaypalGatewayModel;

  AutomaticPaymentPaypalGatewayModel get automaticPaymentPaypalGatewayModel =>
      _automaticPaymentPaypalGatewayModel;

  Future<AutomaticPaymentPaypalGatewayModel>
      automaticPaymentPaypalGatewaysProcess(inputBody) async {
    _isPaypalLoading.value = true;
    update();
    await ApiServices.automaticPaymentPaypalGatewayApi(body: inputBody)
        .then((value) {
      _automaticPaymentPaypalGatewayModel = value!;
      update();
      Get.toNamed(Routes.webPaymentScreen);
    }).catchError((onError) {
      log.e(onError);
      _isPaypalLoading.value = false;
    });

    _isPaypalLoading.value = false;

    update();
    return _automaticPaymentPaypalGatewayModel;
  }

  // Automatic Payment Stripe Gateway Model
  late AutomaticPaymentStripeGatewayModel _automaticPaymentStripeGatewayModel;

  AutomaticPaymentStripeGatewayModel get automaticPaymentStripeGatewayModel =>
      _automaticPaymentStripeGatewayModel;

  Future<AutomaticPaymentStripeGatewayModel>
      automaticPaymentStripeGatewaysProcess(inputBody) async {
    _isStripeLoading.value = true;
    update();

    await ApiServices.automaticPaymentStripeGatewayApi(body: inputBody)
        .then((value) {
      _automaticPaymentStripeGatewayModel = value!;

      update();

      Get.toNamed(Routes.stripeWebPaymentScreen);
    }).catchError((onError) {
      log.e(onError);
      _isStripeLoading.value = false;
    });

    _isStripeLoading.value = false;

    update();
    return _automaticPaymentStripeGatewayModel;
  }

  //! Automatic sslcommerz Model
  late AutomaticPaymentSslcommerzModel _automaticPaymentSslcommerzModel;

  AutomaticPaymentSslcommerzModel get automaticPaymentSslcommerzModel =>
      _automaticPaymentSslcommerzModel;

  Future<AutomaticPaymentSslcommerzModel> automaticSslCommerzProcess(
      inputBody) async {
    _isStripeLoading.value = true;
    update();

    await ApiServices.automaticSslcommerzApi(body: inputBody).then((value) {
      _automaticPaymentSslcommerzModel = value!;

      update();

      Get.toNamed(Routes.sslCommerzWebPaymentScreen);
    }).catchError((onError) {
      log.e(onError);
      _isStripeLoading.value = false;
    });

    _isStripeLoading.value = false;

    update();
    return _automaticPaymentSslcommerzModel;
  }

  //! Automatic flutterwave Model
  late AutomaticPaymentFlutterwaveModel _automaticPaymentFlutterwaveModel;

  AutomaticPaymentFlutterwaveModel get automaticPaymentFlutterwaveModel =>
      _automaticPaymentFlutterwaveModel;

  Future<AutomaticPaymentFlutterwaveModel> automaticFlutterwaveProcess(
      inputBody) async {
    _isStripeLoading.value = true;
    update();

    await ApiServices.automaticFlutterwaveApi(body: inputBody).then((value) {
      _automaticPaymentFlutterwaveModel = value!;

      update();

      Get.toNamed(Routes.flutterWebPaymentScreen);
    }).catchError((onError) {
      log.e(onError);
      _isStripeLoading.value = false;
    });

    _isStripeLoading.value = false;

    update();
    return _automaticPaymentFlutterwaveModel;
  }

  //! Automatic razorpay Model
  late AutomaticPaymentRazorpayModel _automaticPaymentRazorpayModel;

  AutomaticPaymentRazorpayModel get automaticPaymentRazorpayModel =>
      _automaticPaymentRazorpayModel;

  Future<AutomaticPaymentRazorpayModel> automaticRazorpayProcess(
      inputBody) async {
    _isStripeLoading.value = true;
    update();

    await ApiServices.automaticRazorpayApi(body: inputBody).then((value) {
      _automaticPaymentRazorpayModel = value!;

      update();

      Get.toNamed(Routes.razorPayWebPaymentScreen);
    }).catchError((onError) {
      log.e(onError);
      _isStripeLoading.value = false;
    });

    _isStripeLoading.value = false;

    update();
    return _automaticPaymentRazorpayModel;
  }

//
  paymentProceed() {
    Map<String, dynamic> inputBody = {
      'amount': double.parse(amountController.text),
      'currency': selectedCurrencyAlias.value,
    };
    switch (selectedCurrencyType.value) {
      case "Type.AUTOMATIC":
        {
          if (selectedCurrencyAlias.contains('stripe')) {
            automaticPaymentStripeGatewaysProcess(inputBody);
          } else if (selectedCurrencyAlias.contains('paypal')) {
            automaticPaymentPaypalGatewaysProcess(inputBody);
          } else if (selectedCurrencyAlias.contains('sslcommerz')) {
            automaticSslCommerzProcess(inputBody);
          } else if (selectedCurrencyAlias.contains('flutterwave')) {
            automaticFlutterwaveProcess(inputBody);
          } else if (selectedCurrencyAlias.contains('razorpay')) {
            automaticRazorpayProcess(inputBody);
          }
        }
        break;
      case "Type.MANUAL":
        {
          manualPaymentController.manualPaymentGatewaysProcess(inputBody);
        }
        break;
    }
  }
}
