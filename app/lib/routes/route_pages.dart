import 'package:stripcard/routes/routes.dart';
import 'package:stripcard/views/auth/login/otp_verification_screen.dart';
import 'package:stripcard/views/auth/registration/email_otp_screen.dart';
import 'package:stripcard/views/auth/registration/sign_up_screen.dart';
import 'package:stripcard/views/categories/deposit/web_payment_screen.dart';
import 'package:stripcard/views/categories/withdraw/withdraw_manual_payment_screen.dart';
import 'package:stripcard/views/categories/withdraw/withdraw_preview_screen.dart';
import 'package:stripcard/views/drawer/change_password_screen.dart';
import 'package:stripcard/views/navbar/bottom_navbar_screen.dart';
import 'package:stripcard/views/navbar/dashboard_screen.dart';
import 'package:stripcard/views/navbar/notification_screen.dart';
import 'package:stripcard/views/onboard/onboard_screen.dart';
import 'package:stripcard/views/profile/my_card_screen.dart';
import 'package:stripcard/views/profile/update_profile_screen.dart';
import 'package:get/get.dart';
import '../backend/services/api_endpoint.dart';
import '../bindings/splash_screen_binding.dart';
import '../language/strings.dart';
import '../views/auth/login/reset_password_screen.dart';
import '../views/auth/login/signin_screen.dart';
import '../views/categories/deposit/deposit_preview_screen.dart';
import '../views/categories/deposit/deposit_screen.dart';
import '../views/categories/deposit/flutterwave_webview_screen.dart';
import '../views/categories/deposit/manual_payment_screen.dart';
import '../views/categories/deposit/razorpay_webview_screen.dart';
import '../views/categories/deposit/sslcommerz_webview_screen.dart';
import '../views/categories/deposit/stripe_web_view_screen.dart';
import '../views/categories/virtual_card/stripe_card/stripe_card_details_screen.dart';
import '../views/categories/virtual_card/stripe_card/stripe_create_card_screen.dart';
import '../views/categories/virtual_card/stripe_card/stripe_transaction_screen.dart';
import '../views/categories/withdraw/withdraw_screen.dart';
import '../views/drawer/transaction_log_screen.dart';
import '../views/drawer/web_view_screen.dart';
import '../views/kyc/kyc_screen.dart';
import '../views/money_transfer/transfer_preview_screen.dart';
import '../views/splash_screen/splash_screen.dart';

class RoutePageList {
  static var list = [
    //!auth
    GetPage(
      name: Routes.splashScreen,
      page: () => SplashScreen(),
      binding: SplashBinding(),
    ),
    GetPage(
      name: Routes.onboardScreen,
      page: () => OnboardScreen(),
    ),

    GetPage(
      name: Routes.signInScreen,
      page: () => SignInScreen(),
    ),
    GetPage(
      name: Routes.resetOtpScreen,
      page: () => ResetOtpScreen(),
    ),
    GetPage(
      name: Routes.resetPasswordScreen,
      page: () => ResetPasswordScreen(),
    ),
    GetPage(
      name: Routes.registrationScreen,
      page: () => RegistrationScreen(),
    ),
    GetPage(
      name: Routes.emailOtpScreen,
      page: () => EmailOtpScreen(),
    ),

    //!categories
    GetPage(
      name: Routes.bottomNavBarScreen,
      page: () => BottomNavBarScreen(),
      // binding: BottomNavBarScreenBinding(),
    ),
    GetPage(
      name: Routes.dashboardScreen,
      page: () => DashboardScreen(),
    ),
    GetPage(
      name: Routes.notificationScreen,
      page: () => NotificationScreen(),
    ),

    GetPage(
      name: Routes.depositScreen,
      page: () => DepositScreen(),
    ),
    GetPage(
      name: Routes.depositPreviewScreen,
      page: () => DepositPreviewScreen(),
    ),

    //help center
    GetPage(
      name: Routes.helpCenter,
      page: () => WebViewScreen(
        title: Strings.helpCenter,
        url: "${ApiEndpoint.mainDomain}/contact",
      ),
    ),

    //privacy policy
    GetPage(
      name: Routes.privacyPolicy,
      page: () => WebViewScreen(
        title: Strings.privacyAndPolicy,
        url: "${ApiEndpoint.mainDomain}/page/privacy-policy",
      ),
    ),

    //about us
    GetPage(
      name: Routes.aboutUs,
      page: () => WebViewScreen(
        title: Strings.aboutUs,
        url: "${ApiEndpoint.mainDomain}/about",
      ),
    ),
    //!drawer screens

    GetPage(
      name: Routes.transactionLogScreen,
      page: () => TransactionLogScreen(),
    ),

    GetPage(
      name: Routes.changePasswordScreen,
      page: () => ChangePasswordScreen(),
    ),

    //!profile screen

    GetPage(
      name: Routes.mygiftCardScreen,
      page: () => MyCardScreen(),
    ),
    GetPage(
      name: Routes.updateProfileScreen,
      page: () => UpdateProfileScreen(),
    ),
    GetPage(
      name: Routes.manualPaymentScreen,
      page: () => ManualPaymentScreen(),
    ),
    GetPage(
      name: Routes.webPaymentScreen,
      page: () => WebPaymentScreen(),
    ),

    GetPage(
      name: Routes.kycScreen,
      page: () => KycScreen(),
    ),

    ///>>>>>>>>>>>> stripe card screen
    GetPage(
      name: Routes.stripeCardDetailsScreen,
      page: () => StripeCardDetailsScreen(),
    ),
    GetPage(
      name: Routes.stripeTransactionHistoryScreen,
      page: () => StripeTransactionHistoryScreen(),
    ),
    GetPage(
      name: Routes.moneyTransferPreviewScreen,
      page: () => MoneyTransferPreviewScreen(),
    ),
    GetPage(
      name: Routes.stripeCreateCardScreen,
      page: () => StripeCreateCardScreen(),
    ),
    GetPage(
      name: Routes.stripeWebPaymentScreen,
      page: () => StripeWebPaymentScreen(),
    ),
    //money out
    GetPage(
      name: Routes.moneyOutScreen,
      page: () => MoneyOutScreen(),
    ),
    GetPage(
      name: Routes.moneyOutManualPaymentScreen,
      page: () => MoneyOutManualPaymentScreen(),
    ),
    GetPage(
      name: Routes.moneyOutPreviewScreen,
      page: () => MoneyOutPreviewScreen(),
    ),
    GetPage(
      name: Routes.flutterWebPaymentScreen,
      page: () => FlutterWebPaymentScreen(),
    ),
    GetPage(
      name: Routes.sslCommerzWebPaymentScreen,
      page: () => SslCommerzWebPaymentScreen(),
    ),
    GetPage(
      name: Routes.razorPayWebPaymentScreen,
      page: () => RazorPayWebPaymentScreen(),
    ),
  ];
}
