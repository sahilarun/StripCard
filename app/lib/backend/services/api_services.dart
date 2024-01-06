import 'package:http/http.dart' as http;
import 'package:stripcard/backend/model/transfer_money/transfer_money_info_model.dart';

import '../model/add_money/add_money_info_model.dart';
import '../model/add_money/automatic_flutterwave.dart';
import '../model/add_money/automatic_paypal_getway.dart';
import '../model/add_money/automatic_razorpay_model.dart';
import '../model/add_money/automatic_ssclcommerz_model.dart';
import '../model/add_money/automatic_stripe_getway_model.dart';
import '../model/add_money/manual_payment_getway_model.dart';
import '../model/auth/login_model.dart';
import '../model/auth/sign_up_model.dart';
import '../model/common/common_success_model.dart';
import '../model/dashboard/dashboard_model.dart';
import '../model/kyc/kyc_info_model.dart';
import '../model/onboard/app_settings_model.dart';
import '../model/others/transaction_model.dart';
import '../model/others/usefull_link_model.dart';
import '../model/profile/profile_info_model.dart';
import '../model/virtual_card/card_charges_model.dart';
import '../model/virtual_card/card_deatils_model.dart';
import '../model/virtual_card/card_transaction_history_model.dart';
import '../model/virtual_card/my_card_model.dart';
import '../model/virtual_card/stripe_models/stripe_card_details_model.dart';
import '../model/virtual_card/stripe_models/stripe_card_info_model.dart';
import '../model/virtual_card/stripe_models/stripe_card_sensitive_model.dart';
import '../model/virtual_card/stripe_models/stripe_transaction_model.dart';
import '../model/withdraw/dynamic_input_withdraw_model.dart';
import '../model/withdraw/withdraw_info_model.dart';
import '../utils/api_method.dart';
import '../utils/custom_snackbar.dart';
import '../utils/logger.dart';
import 'api_endpoint.dart';

final log = logger(ApiServices);

class ApiServices {
  static var client = http.Client();

// App Settings Api
  static Future<AppSettingsModel?> appSettingsApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: true).get(
        ApiEndpoint.appSettingsURL,
        showResult: true,
      );
      if (mapResponse != null) {
        AppSettingsModel appSettingsModel =
            AppSettingsModel.fromJson(mapResponse);

        return appSettingsModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from App Settings Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in App Settings Model');
      return null;
    }
    return null;
  }

//Login Api method
  static Future<LoginModel?> loginApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: true).post(
        ApiEndpoint.loginURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        LoginModel loginModel = LoginModel.fromJson(mapResponse);
        //CustomSnackBar.success(loginModel.message.success.first.toString());
        return loginModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from login api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in LoginModel');
      return null;
    }
    return null;
  }

  //forget password insert Api method
  static Future<CommonSuccessModel?> forgetPasswordApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: true).post(
        ApiEndpoint.forgetPasswordURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel forgetPasswordModel =
            CommonSuccessModel.fromJson(mapResponse);

        //CustomSnackBar.success(forgetPasswordModel.message.success.first.toString());
        return forgetPasswordModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from login Forget Password Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Forget Password Api');
      return null;
    }
    return null;
  }

  //forget password verify email Api method
  static Future<CommonSuccessModel?> forgetPasswordVerifyEmailApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: true).post(
        ApiEndpoint.forgetPasswordVerifyURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel forgetPasswordVerifyEmailModel =
            CommonSuccessModel.fromJson(mapResponse);
        CustomSnackBar.success(
            forgetPasswordVerifyEmailModel.message.success.first.toString());
        return forgetPasswordVerifyEmailModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from Forget Password Email Verify Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error(
          'Something went Wrong! in Forget Password Email Verify Api');
      return null;
    }
    return null;
  }

  // password  reset code
  static Future<CommonSuccessModel?> passwordResetCodeApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: true).post(
        ApiEndpoint.forgetPasswordURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel forgetPasswordVerifyEmailModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     forgetPasswordVerifyEmailModel.message.success.first.toString());
        return forgetPasswordVerifyEmailModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Password Reset Code Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Password Reset Code Api');
      return null;
    }
    return null;
  }

  // change password Api method
  static Future<CommonSuccessModel?> changePasswordApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: true).post(
        ApiEndpoint.resetPasswordURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel changePasswordModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     changePasswordModel.message.success.first.toString());
        return changePasswordModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from change Password Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in change Password Api');
      return null;
    }
    return null;
  }

//Register Api method
  static Future<SignUpModel?> registerApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: true).post(
        ApiEndpoint.registerURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        SignUpModel registerModel = SignUpModel.fromJson(mapResponse);
        // CustomSnackBar.success(registerModel.message.success.first.toString());
        return registerModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from  Register Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Register Api');
      return null;
    }
    return null;
  }

  //verify email Api method
  static Future<CommonSuccessModel?> verifyMailCodeApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.emailVerifyURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel mailVerifyCodeModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     mailVerifyCodeModel.message.success.first.toString());
        return mailVerifyCodeModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from verify Mail Code Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in verify Mail Code Api');
      return null;
    }
    return null;
  }

  //resend email Api method
  static Future<CommonSuccessModel?> resendVerificationCodeApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.sendCodeURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel mailCodeModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(mailCodeModel.message.success.first.toString());
        return mailCodeModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from resend Verification Code Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error(
          'Something went Wrong! in resend Verification Code Api');
      return null;
    }
    return null;
  }

  //profile Api method
  static Future<ProfileModel?> userProfileApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.profileInfoURL,
        showResult: true,
      );
      if (mapResponse != null) {
        ProfileModel userProfileModel = ProfileModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     userProfileModel.message.success.first.toString());
        return userProfileModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from User Profile Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in User Profile Api');
      return null;
    }
    return null;
  }

  //update password Api method
  static Future<CommonSuccessModel?> updatePasswordApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.passwordUpdateURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel changePasswordModel =
            CommonSuccessModel.fromJson(mapResponse);
        CustomSnackBar.success(
            changePasswordModel.message.success.first.toString());
        return changePasswordModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from change Password Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in change Password Api');
      return null;
    }
    return null;
  }

  //dashboard Api method
  static Future<DashBoardModel?> dashboardApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.dashboardURL,
        duration: 24,
        showResult: true,
      );
      if (mapResponse != null) {
        DashBoardModel dashboardModel = DashBoardModel.fromJson(mapResponse);
        // CustomSnackBar.success(dashboardModel.message.success.first.toString());
        return dashboardModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Dashboard Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Dashboard Api');
      return null;
    }
    return null;
  }

  //My Card Api method
  static Future<MyCardModel?> myCardApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.myCardURL,
        showResult: true,
      );
      if (mapResponse != null) {
        MyCardModel myCardModel = MyCardModel.fromJson(mapResponse);
        // CustomSnackBar.success(myCardModel.message.success.first.toString());
        return myCardModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from my Card Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in my Card Api');
      return null;
    }
    return null;
  }

  //My Card Details Api method
  static Future<CardDetailsModel?> cardDetailsApi(String cardId) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        "${ApiEndpoint.cardDetailsURL} ${cardId}",
        showResult: true,
      );
      if (mapResponse != null) {
        CardDetailsModel cardDetailsModel =
            CardDetailsModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     cardDetailsModel.message.success.first.toString());
        return cardDetailsModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from my Card Details Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in my Card Details Api');
      return null;
    }
    return null;
  }

  // card transaction api
  static Future<CardTransactionsModel?> cardTransactionApi(
      String cardId) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        "${ApiEndpoint.cardTransactionsURL} ${cardId}",
        showResult: true,
      );
      if (mapResponse != null) {
        CardTransactionsModel cardTransactionModel =
            CardTransactionsModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     cardTransactionModel.message.success.first.toString());
        return cardTransactionModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from my Card Transaction Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in my Card Transaction Api');
      return null;
    }
    return null;
  }

  // card charges info api
  static Future<CardChargesModel?> cardChargesApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.cardChargesURL,
        showResult: true,
      );
      if (mapResponse != null) {
        CardChargesModel cardChargesModel =
            CardChargesModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     cardChargesModel.message.success.first.toString());
        return cardChargesModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Card Charges Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Card Charges Model');
      return null;
    }
    return null;
  }

  //create card Api method
  static Future<CommonSuccessModel?> createCardApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.buyCardURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel createCardModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     createCardModel.message.success.first.toString());
        return createCardModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from create card api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in create Card Model');
      return null;
    }
    return null;
  }

  //Card Block Api Method
  static Future<CommonSuccessModel?> cardBlockApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.cardBlockURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel cardBlockModel =
            CommonSuccessModel.fromJson(mapResponse);
        CustomSnackBar.success(cardBlockModel.message.success.first.toString());
        return cardBlockModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Card Block api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Card Block Model');
      return null;
    }
    return null;
  }

  //Card unBlock Api Method
  static Future<CommonSuccessModel?> cardUnblockApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.cardUnblockURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel cardUnblockModel =
            CommonSuccessModel.fromJson(mapResponse);
        CustomSnackBar.success(
            cardUnblockModel.message.success.first.toString());
        return cardUnblockModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Card Unblock api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Card UnBlock Model');
      return null;
    }
    return null;
  }

  //Card Fund Api Method
  static Future<CommonSuccessModel?> cardFundApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.cardFundURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel cardFundModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(cardFundModel.message.success.first.toString());
        return cardFundModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Card Fund api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Card Fund Model');
      return null;
    }
    return null;
  }

  //Card withdraw Api Method
  static Future<CommonSuccessModel?> cardWithdrawApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.withdrawFromCardURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel cardWithdrawModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     cardWithdrawModel.message.success.first.toString());
        return cardWithdrawModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Card Withdraw api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Card Withdraw Model');
      return null;
    }
    return null;
  }

  // add money manual Api
  static Future<ManualPaymentGatewayModel?> manualPaymentApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.addMoneySubmitURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        ManualPaymentGatewayModel manualPaymentGetGatewayModel =
            ManualPaymentGatewayModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     manualPaymentGetGatewayModel.message.success.first.toString());
        return manualPaymentGetGatewayModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Manual Payment Gateway api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error(
          'Something went Wrong! in ManualPaymentGetGatewayModel');
      return null;
    }
    return null;
  }

  // add money Automatic Payment Paypal Gateway
  static Future<AutomaticPaymentPaypalGatewayModel?>
      automaticPaymentPaypalGatewayApi(
          {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.addMoneySubmitURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        AutomaticPaymentPaypalGatewayModel automaticPaymentPaypalGatewayModel =
            AutomaticPaymentPaypalGatewayModel.fromJson(mapResponse);
        // CustomSnackBar.success(automaticPaymentPaypalGatewayModel
        //     .message.success.first
        //     .toString());
        return automaticPaymentPaypalGatewayModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from automatic Payment Paypal Gateway api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error(
          'Something went Wrong! in automaticPaymentPaypalGatewayModel');
      return null;
    }
    return null;
  }

  // add money Automatic Payment Stripe Gateway
  static Future<AutomaticPaymentStripeGatewayModel?>
      automaticPaymentStripeGatewayApi(
          {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.addMoneySubmitURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        AutomaticPaymentStripeGatewayModel automaticPaymentStripeGatewayModel =
            AutomaticPaymentStripeGatewayModel.fromJson(mapResponse);
        // CustomSnackBar.success(automaticPaymentStripeGatewayModel
        //     .message.success.first
        //     .toString());
        return automaticPaymentStripeGatewayModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from automatic Payment Stripe Gateway api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error(
          'Something went Wrong! in automaticPaymentStripeGatewayModel');
      return null;
    }
    return null;
  }

  // Stripe Confirm Api
  static Future<CommonSuccessModel?> stripeConfirmApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.StripeConfirmedURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel stripeConfirmModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     stripeConfirmModel.message.success.first.toString());
        return stripeConfirmModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Stripe Confirm Api  service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in Stripe Confirm Api ');
      return null;
    }
    return null;
  }

  //add Money Manual Confirmed Api
  static Future<CommonSuccessModel?> addMoneyManualConfirmedApi({
    required Map<String, String> body,
    required List<String> pathList,
    required List<String> fieldList,
  }) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).multipartMultiFile(
        ApiEndpoint.addMoneyManualConfirmedURL,
        body,
        showResult: true,
        fieldList: fieldList,
        pathList: pathList,
      );
      if (mapResponse != null) {
        CommonSuccessModel addMoneyManualConfirmedModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     addMoneyManualConfirmedModel.message.success.first.toString());
        return addMoneyManualConfirmedModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from Add Money Manual Confirmed api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error(
          'Something went Wrong! in Add Money Manual Confirmed Model');
      return null;
    }
    return null;
  }

  // Add Money Info Api
  static Future<AddMoneyInfoModel?> addMoneyInfoApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.addMoneyInfoURL,
        showResult: true,
      );
      if (mapResponse != null) {
        AddMoneyInfoModel addMoneyInfoModel =
            AddMoneyInfoModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     addMoneyInfoModel.message.success.first.toString());
        return addMoneyInfoModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from Add Money Info Api  service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in addMoneyInfoModel');
      return null;
    }
    return null;
  }

  //  update profile Without Image Api method
  static Future<CommonSuccessModel?> updateProfileWithoutImageApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false)
          .post(ApiEndpoint.profileUpdateURL, body, code: 200);
      if (mapResponse != null) {
        CommonSuccessModel updateProfileModel =
            CommonSuccessModel.fromJson(mapResponse);
        CustomSnackBar.success(
            updateProfileModel.message.success.first.toString());
        return updateProfileModel;
      }
    } catch (e) {
      log.e('err from update profile api service ==> $e');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  // update profile With Image api
  static Future<CommonSuccessModel?> updateProfileWithImageApi(
      {required Map<String, String> body, required String filepath}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).multipart(
        ApiEndpoint.profileUpdateURL,
        body,
        filepath,
        'image',
        code: 200,
      );

      if (mapResponse != null) {
        CommonSuccessModel profileUpdateModel =
            CommonSuccessModel.fromJson(mapResponse);
        CustomSnackBar.success(
            profileUpdateModel.message.success.first.toString());
        return profileUpdateModel;
      }
    } catch (e) {
      log.e('err from profile update api service ==> $e');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  //  log Out
  static Future<CommonSuccessModel?> logOutApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse =
          await ApiMethod(isBasic: false).get(ApiEndpoint.logOutURL, code: 200);
      if (mapResponse != null) {
        CommonSuccessModel updateProfileModel =
            CommonSuccessModel.fromJson(mapResponse);
        CustomSnackBar.success(
            updateProfileModel.message.success.first.toString());
        return updateProfileModel;
      }
    } catch (e) {
      log.e('err from log Out api service ==> $e');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

//useFullLinkApi
  static Future<UseFullLinkModel?> useFullLinkApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.usefulLinks,
        showResult: true,
      );
      if (mapResponse != null) {
        UseFullLinkModel useFullLinkModel =
            UseFullLinkModel.fromJson(mapResponse);

        return useFullLinkModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from use Full Link Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in use Full Link Model');
      return null;
    }
    return null;
  }

  //kyc Additional field method
  static Future<KycInfoModel?> kycInputFieldsApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.kycInfoURL,
        code: 200,
        duration: 15,
        showResult: true,
      );
      if (mapResponse != null) {
        KycInfoModel kycInfoModel = KycInfoModel.fromJson(mapResponse);
        return kycInfoModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from kyc additional field api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  //submit manual payment gateway Api method
  static Future<CommonSuccessModel?> submitKycApi({
    required Map<String, String> body,
    required List<String> pathList,
    required List<String> fieldList,
  }) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).multipartMultiFile(
        ApiEndpoint.submitKycURL,
        body,
        code: 200,
        // duration: 15,
        showResult: true,
        fieldList: fieldList,
        pathList: pathList,
      );
      if (mapResponse != null) {
        CommonSuccessModel commonSuccessModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     automaticPaymentGatewayModel.message.success.first.toString());
        return commonSuccessModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from kyc submit api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

//
// ---------------------------------------------------------------------------
//                              Virtual Card Stripe
// ---------------------------------------------------------------------------
//

  //stripe card info api
  static Future<StripeCardInfoModel?> stripeCardInfoApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.stripeCardInfoURL,
        code: 200,
        showResult: false,
      );
      if (mapResponse != null) {
        StripeCardInfoModel cardInfoModel =
            StripeCardInfoModel.fromJson(mapResponse);

        return cardInfoModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from stripe card info api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in stripe card info Api');
      return null;
    }
    return null;
  }

  // stripe card details api
  static Future<StripeCardDetailsModel?> stripeCardDetailsApi(String id) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.stripeCardDetailsURL + id,
        code: 200,
        showResult: false,
      );
      if (mapResponse != null) {
        StripeCardDetailsModel cardDetailsModel =
            StripeCardDetailsModel.fromJson(mapResponse);

        return cardDetailsModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from stripe card details api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error(
          'Something went Wrong! in stripe card details info Api');
      return null;
    }
    return null;
  }

//stripe card transaction method
  static Future<StripeCardTransactionModel?> stripeCardTransactionApi(
      String cardId) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        "${ApiEndpoint.stripeCardTransactionURL}${cardId}",
        showResult: true,
      );
      if (mapResponse != null) {
        StripeCardTransactionModel cardTransactionModel =
            StripeCardTransactionModel.fromJson(mapResponse);
        // CustomSnackBar.error(
        //     cardTransactionModel.message.success.first.toString());
        return cardTransactionModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from my stripe Card Transaction Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  // stripe card sensitive api
  static Future<StripeSensitiveModel?> stripeSensitiveApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.stripeSensitiveURl,
        body,
        code: 200,
        showResult: false,
      );
      if (mapResponse != null) {
        StripeSensitiveModel cardBlockModel =
            StripeSensitiveModel.fromJson(mapResponse);

        return cardBlockModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from stripe sensitive api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in stripe sensitive Api');
      return null;
    }
    return null;
  }

  //stripe card inactive api
  static Future<CommonSuccessModel?> stripeInactiveApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.stripeInactiveURl,
        body,
        code: 200,
        showResult: false,
      );
      if (mapResponse != null) {
        CommonSuccessModel cardUnBlockModel =
            CommonSuccessModel.fromJson(mapResponse);

        return cardUnBlockModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from inactive api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! inactive Api');
      return null;
    }
    return null;
  }

  // stripe card active api
  static Future<CommonSuccessModel?> stripeActiveApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.stripeActiveURl,
        body,
        code: 200,
        showResult: false,
      );
      if (mapResponse != null) {
        CommonSuccessModel cardUnBlockModel =
            CommonSuccessModel.fromJson(mapResponse);

        return cardUnBlockModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from stripe card active Api api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error(
          'Something went Wrong! in stripe card active  Api info Api');
      return null;
    }
    return null;
  }

  //stripe card buy  Api Method
  static Future<CommonSuccessModel?> stripeBuyCardApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.stripeBuyCardURl,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel cardUnblockModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.error(cardUnblockModel.message.success.first.toString());
        return cardUnblockModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from stripe card buy api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in stripe card buy Model');
      return null;
    }
    return null;
  }

  ///>>>>>>>>>>>>>>>>>>>>.. transfer money
  static Future<CommonSuccessModel?> transferMoneyCheckUserApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.transferCheckUserURl,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel cardUnblockModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.error(
        //     cardUnblockModel.message.success.first.toString());
        return cardUnblockModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from transfer money check user api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  //transfer money info
  static Future<TransferMoneyInfoModel?> transferMoneyInfoApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.transferInfoURl,
        showResult: true,
      );
      if (mapResponse != null) {
        TransferMoneyInfoModel transferMoneyInfoModel =
            TransferMoneyInfoModel.fromJson(mapResponse);
        // CustomSnackBar.error(
        //     transferMoneyInfoModel.message.success.first.toString());
        return transferMoneyInfoModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from transfer money info Api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  //transfer money confirm
  static Future<CommonSuccessModel?> transferMoneyConfirmApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.transferConfirmURl,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        CommonSuccessModel cardUnblockModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.error(
        //     cardUnblockModel.message.success.first.toString());
        return cardUnblockModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from transfer money confirm api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  /// transaction api method

  /// transaction
  static Future<TransationLogModel?> getTransactionLogAPi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.transactionLogURL,
        code: 200,
        showResult: false,
      );
      if (mapResponse != null) {
        TransationLogModel modelData = TransationLogModel.fromJson(mapResponse);

        return modelData;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from all transaction info  service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  //withdraw
  //withdraw info
  static Future<WithdrawInfoModel?> withdrawInfoApi() async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).get(
        ApiEndpoint.withdrawInfoURL,
        code: 200,
        showResult: false,
      );
      if (mapResponse != null) {
        WithdrawInfoModel withdrawInfoModel =
            WithdrawInfoModel.fromJson(mapResponse);

        return withdrawInfoModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from withdraw info api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong! in withdraw info api');
      return null;
    }
    return null;
  }

//withdraw dynamic
  static Future<DynamicInputWithdrawModel?> withdrawInsertApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false)
          .post(ApiEndpoint.withdrawInsertURL, body, code: 200);
      if (mapResponse != null) {
        DynamicInputWithdrawModel result =
            DynamicInputWithdrawModel.fromJson(mapResponse);
        return result;
      }
    } catch (e) {
      log.e('err from money out insert process api service ==> $e');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  // withdraw submit
  static Future<CommonSuccessModel?> withdrawSubmitApi({
    required Map<String, String> body,
    required List<String> pathList,
    required List<String> fieldList,
  }) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: true).multipartMultiFile(
        ApiEndpoint.withdrawConfirmURL,
        body,
        showResult: true,
        fieldList: fieldList,
        pathList: pathList,
      );
      if (mapResponse != null) {
        CommonSuccessModel registrationModel =
            CommonSuccessModel.fromJson(mapResponse);
        // CustomSnackBar.success(
        //     registrationModel.message.success.first.toString());

        return registrationModel;
      }
    } catch (e) {
      log.e('🐞🐞🐞 err from withdraw submit api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  // add money Automatic Payment Stripe Gateway
  static Future<AutomaticPaymentSslcommerzModel?> automaticSslcommerzApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.addMoneySubmitURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        AutomaticPaymentSslcommerzModel automaticPaymentSslcommerzModel =
            AutomaticPaymentSslcommerzModel.fromJson(mapResponse);
        return automaticPaymentSslcommerzModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from automatic Payment sslcommerz Gateway api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  // add money Automatic Payment Stripe Gateway
  static Future<AutomaticPaymentFlutterwaveModel?> automaticFlutterwaveApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.addMoneySubmitURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        AutomaticPaymentFlutterwaveModel automaticPaymentFlutterwaveModel =
            AutomaticPaymentFlutterwaveModel.fromJson(mapResponse);
        return automaticPaymentFlutterwaveModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from automatic Payment flutterwave Gateway api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }

  // add money Automatic Payment Stripe Gateway
  static Future<AutomaticPaymentRazorpayModel?> automaticRazorpayApi(
      {required Map<String, dynamic> body}) async {
    Map<String, dynamic>? mapResponse;
    try {
      mapResponse = await ApiMethod(isBasic: false).post(
        ApiEndpoint.addMoneySubmitURL,
        body,
        showResult: true,
      );
      if (mapResponse != null) {
        AutomaticPaymentRazorpayModel automaticPaymentRazorpayModel =
            AutomaticPaymentRazorpayModel.fromJson(mapResponse);
        return automaticPaymentRazorpayModel;
      }
    } catch (e) {
      log.e(
          '🐞🐞🐞 err from automatic Payment razorpay Gateway api service ==> $e 🐞🐞🐞');
      CustomSnackBar.error('Something went Wrong!');
      return null;
    }
    return null;
  }
}
