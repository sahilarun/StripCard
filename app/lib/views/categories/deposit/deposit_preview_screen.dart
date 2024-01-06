import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/widgets/others/preview/amount_preview_widget.dart';
import 'package:stripcard/widgets/others/preview/information_amount_widget.dart';
import '../../../controller/navbar/deposit/deposit_controller.dart';
import '../../../controller/navbar/deposit/manual_gateway_controller.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../widgets/appbar/appbar_widget.dart';

class DepositPreviewScreen extends StatelessWidget {
  DepositPreviewScreen({super.key});
  final depositController = Get.put(DepositController());
  final manualController = Get.put(ManualPaymentController());
  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
        mobileScaffold: Scaffold(
      appBar: AppBarWidget(text: Strings.preview),
      body: _bodyWidget(context),
    ));
  }

  _bodyWidget(BuildContext context) {
    return ListView(
      padding: EdgeInsets.symmetric(horizontal: Dimensions.paddingSize * 0.8),
      physics: BouncingScrollPhysics(),
      children: [
        _amountWidget(context),
        _amountInformationWidget(context),
        _buttonWidget(context),
      ],
    );
  }

  _amountWidget(BuildContext context) {
    return previewAmount(
      amount: "${depositController.amountController.text} ${"USD"}",
    );
  }

  _amountInformationWidget(BuildContext context) {
    var _fixedCharge =
        depositController.fee * depositController.rate.toDouble();
    double amount = double.parse(depositController.amountController.text);

    double percentCharge =
        (amount / 100) * depositController.percentCharge.toDouble();

    double totalCharge =
        _fixedCharge + percentCharge * depositController.rate.value;
    double totalPayable =
        ((amount * depositController.rate.value) + totalCharge);
    return amountInformationWidget(
      information: Strings.amountInformation,
      enterAmount: Strings.enterAmount,
      exChange: Strings.exchangeRate,
      exChangeRow:
          "${depositController.baseCurrencyRate} ${depositController.baseCurrency.value} = ${depositController.rate.value.toStringAsFixed(2)} ${depositController.code.value}",
      enterAmountRow:
          "${depositController.amountController.text} ${depositController.baseCurrency.value}",
      fee: Strings.transferFees,
      feeRow:
          "${totalCharge.toStringAsFixed(2)} ${depositController.code.value}",
      received: Strings.recipientReceived,
      receivedRow:
          "${amount.toStringAsFixed(2)} ${depositController.baseCurrency.value}",
      total: Strings.totalPayable,
      totalRow:
          "${totalPayable.toStringAsFixed(2)} ${depositController.code.value}",
    );
  }

  _buttonWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(
        top: Dimensions.marginSizeVertical * 2,
      ),
      child: Obx(
        () => depositController.isPaypalLoading ||
                depositController.isStripeLoading ||
                manualController.isLoading
            ? CustomLoadingAPI(
                color: CustomColor.primaryLightColor,
              )
            : PrimaryButton(
                title: Strings.confirm,
                onPressed: () {
                  print("click on confirm");
                  depositController.paymentProceed();
                }),
      ),
    );
  }
}
