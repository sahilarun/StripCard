import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/controller/navbar/withdraw/withdraw_controller.dart';
import 'package:stripcard/widgets/others/preview/amount_preview_widget.dart';
import 'package:stripcard/widgets/others/preview/information_amount_widget.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../widgets/appbar/appbar_widget.dart';

class MoneyOutPreviewScreen extends StatelessWidget {
  MoneyOutPreviewScreen({super.key});
  final controller = Get.put(MoneyOutController());
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
      amount: controller.requestAmount,
    );
  }

  _amountInformationWidget(BuildContext context) {
    return amountInformationWidget(
      information: Strings.amountInformation,
      enterAmount: Strings.enterAmount,
      exChange: Strings.exchangeRate,
      exChangeRow: "${controller.exchangeRate} ",
      enterAmountRow: "${controller.requestAmount}",
      fee: Strings.transferFees,
      feeRow: "${controller.totalCharge}",
      received: Strings.recipientReceived,
      receivedRow: "${controller.youWillGet}",
      total: Strings.totalPayable,
      totalRow: "${controller.payableAmount}",
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
                  controller.confirmProcess(context);
                }),
      ),
    );
  }
}
