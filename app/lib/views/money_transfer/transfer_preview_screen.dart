import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/widgets/appbar/appbar_widget.dart';
import 'package:stripcard/utils/basic_screen_import.dart';
import 'package:stripcard/widgets/others/preview/amount_preview_widget.dart';
import 'package:stripcard/widgets/others/preview/information_amount_widget.dart';

import '../../controller/navbar/money_transfer/money_transfer_controller.dart';
import '../../controller/navbar/money_transfer/money_transfer_info_controller.dart';

class MoneyTransferPreviewScreen extends StatelessWidget {
  MoneyTransferPreviewScreen({super.key});
  final controller = Get.put(MoneyTransferController());
  final infoController = Get.put(MoneyTransferInfoController());
  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        appBar: AppBarWidget(text: Strings.preview),
        body: Obx(
          () => infoController.isLoading
              ? CustomLoadingAPI(
                  color: CustomColor.primaryLightColor,
                )
              : _bodyWidget(context),
        ),
      ),
    );
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
    var data = infoController.transferMoneyInfoModel.data;

    return previewAmount(
        amount: "${controller.amountController.text} ${data.baseCurr}");
  }

  _amountInformationWidget(BuildContext context) {
    var data = infoController.transferMoneyInfoModel.data;
    var _fixedCharge = data.transferMoneyCharge.fixedCharge * data.baseCurrRate;
    double amount = double.parse(controller.amountController.text);

    double percentCharge =
        (amount / 100) * data.transferMoneyCharge.percentCharge;

    double totalCharge = _fixedCharge + percentCharge;
    double totalPayable = amount + totalCharge;
    return amountInformationWidget(
      information: Strings.amountInformation,
      enterAmount: Strings.enterAmount,
      exChange: Strings.exchangeRate,
      exChangeRow: "1 ${data.baseCurr} = 1 ${data.baseCurr}",
      enterAmountRow: "${controller.amountController.text} ${data.baseCurr}",
      fee: Strings.transferFees,
      feeRow: "${totalCharge.toString()} ${data.baseCurr}",
      received: Strings.recipientReceived,
      receivedRow: "${amount.toStringAsFixed(2)} ${data.baseCurr}",
      total: Strings.totalPayable,
      totalRow: "${totalPayable.toString()} ${data.baseCurr}",
    );
  }

  _buttonWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(
        top: Dimensions.marginSizeVertical * 2,
      ),
      child: Obx(
        () => controller.isConfirmLoading
            ? CustomLoadingAPI(
              color: CustomColor.primaryLightColor,
            )
            : PrimaryButton(
                title: Strings.confirm,
                onPressed: () {
                  controller.transferMoneyConfirmProcess(context);
                }),
      ),
    );
  }
}
