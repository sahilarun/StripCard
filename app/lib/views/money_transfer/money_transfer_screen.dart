import 'package:google_fonts/google_fonts.dart';
import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/widgets/inputs/primary_input_filed.dart';
import '../../../backend/local_storage.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../widgets/inputs/input_with_text.dart';
import '../../backend/utils/custom_snackbar.dart';
import '../../controller/navbar/money_transfer/money_transfer_controller.dart';
import '../../controller/navbar/money_transfer/money_transfer_info_controller.dart';

class MonetTransferScreen extends StatelessWidget {
  MonetTransferScreen({super.key});

  final controller = Get.put(MoneyTransferController());
  final infoController = Get.put(MoneyTransferInfoController());

  final moneyTransferFormKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        appBar: AppBar(
          automaticallyImplyLeading: false,
          title: Text(
            Strings.moneyTransfer,
            style: CustomStyle.darkHeading4TextStyle.copyWith(
              fontSize: Dimensions.headingTextSize1,
              fontWeight: FontWeight.w500,
              color: CustomColor.primaryLightTextColor,
            ),
          ),
          centerTitle: true,
          elevation: 0,
          backgroundColor: CustomColor.primaryLightScaffoldBackgroundColor,
        ),
        body: _bodyWidget(context),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    return ListView(
      physics: BouncingScrollPhysics(),
      padding: EdgeInsets.symmetric(
        horizontal: Dimensions.paddingSize * 0.8,
      ),
      children: [
        _inputWidget(context),
        _buttonWidget(context),
      ],
    );
  }

  _inputWidget(BuildContext context) {
    var data = infoController.transferMoneyInfoModel.data.transferMoneyCharge;
    var baseCurrency = infoController.transferMoneyInfoModel.data.baseCurr;
    return Form(
      key: moneyTransferFormKey,
      child: Column(
        crossAxisAlignment: crossStart,
        children: [
          verticalSpace(Dimensions.heightSize * 2),
          PrimaryInputWidget(
            keyboardInputType: TextInputType.emailAddress,
            controller: controller.receiverEmailController,
            hint: Strings.enterReceiverEmailAddress,
            label: Strings.receiverEmail,
          ),
          verticalSpace(Dimensions.heightSize),
          InputWithText(
            controller: controller.amountController,
            hint: Strings.zero00,
            label: Strings.amount,
            suffixText: LocalStorage.getBaseCurrency() ?? 'USD',
          ),
          verticalSpace(Dimensions.heightSize * 0.5),
          Text(
            "${Strings.limit}: ${data.minLimit.toStringAsFixed(2)} ${baseCurrency} - ${data.maxLimit.toStringAsFixed(2)} ${baseCurrency}",
            textAlign: TextAlign.left,
            style: GoogleFonts.inter(
              fontSize: Dimensions.headingTextSize5,
              fontWeight: FontWeight.w500,
              color: CustomColor.primaryLightTextColor,
            ),
          ),
        ],
      ),
    );
  }

  _buttonWidget(BuildContext context) {
    var data = infoController.transferMoneyInfoModel.data.transferMoneyCharge;
    return Container(
      margin: EdgeInsets.symmetric(
        vertical: Dimensions.marginSizeVertical * 1.6,
      ),
      child: Obx(() => controller.isLoading
          ? CustomLoadingAPI(
              color: CustomColor.primaryLightColor,
            )
          : PrimaryButton(
              title: Strings.proceed,
              onPressed: () {
                double amount = double.parse(controller.amountController.text);
                if (controller.amountController.text.isNotEmpty) {
                  if (data.minLimit <= amount && data.maxLimit >= amount) {
                    controller.transferCheckUserProcess();
                  } else {
                    CustomSnackBar.error(Strings.pleaseFollowTheLimit);
                  }
                 
                } 
              },
            )),
    );
  }
}
