import 'package:stripcard/backend/utils/custom_snackbar.dart';

import '../../../../backend/local_storage.dart';
import '../../../../backend/utils/custom_loading_api.dart';
import '../../../../controller/categories/virtual_card/stripe_card/stripe_card_controller.dart';
import '../../../../utils/basic_screen_import.dart';
import '../../../../widgets/appbar/appbar_widget.dart';
import '../../../../widgets/inputs/input_with_text.dart';
import '../../../../widgets/others/flip_card_widget.dart';

class StripeCreateCardScreen extends StatelessWidget {
  StripeCreateCardScreen({super.key});
  final controller = Get.put(StripeCardController());
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBarWidget(text: Strings.createANewCard),
      body: _bodyWidget(context),
    );
  }

  _bodyWidget(BuildContext context) {
    return ListView(
      padding: EdgeInsets.symmetric(horizontal: Dimensions.paddingSize * 0.7),
      children: [
        _imageWidget(context),
        _inputFields(context),
        _limitBalance(context),
        _chargeWidget(context),
        _buttonWidget(context),
      ],
    );
  }

  _imageWidget(BuildContext context) {
    return CrateFlipCardWidget(
      title: Strings.visa,
      availableBalance: Strings.cardHolder,
      cardNumber: 'xxxx xxxx xxxx xxxx',
      expiryDate: 'xx/xx',
      balance: 'xx',
      validAt: 'xx',
      cvv: 'xxx',
      logo: Assets.logo.basicPn.path,
      isNetworkImage: false,
    );
  }

  _inputFields(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(top: Dimensions.paddingSize),
      child: InputWithText(
        controller: controller.fundAmountController,
        hint: Strings.zero00,
        label: Strings.fundAmount,
        suffixText: LocalStorage.getBaseCurrency() ?? 'USD',
        onChanged: (value) {
          controller.getStripeCardData();
        },
      ),
    );
  }

  _limitBalance(BuildContext context) {
    var userData = controller.stripeCardModel.data.userWallet;
    var limitData = controller.stripeCardModel.data.cardCharge;
    return Container(
      margin: EdgeInsets.only(
        top: Dimensions.marginSizeVertical * 0.3,
        bottom: Dimensions.marginSizeVertical * 2,
      ),
      child: Column(
        crossAxisAlignment: crossStart,
        children: [
          Row(
            children: [
              TitleHeading4Widget(
                text: Strings.limit,
                color: CustomColor.primaryLightColor,
              ),
              TitleHeading4Widget(
                text:
                    ": ${limitData.minLimit} ${userData.currency} - ${limitData.maxLimit} ${userData.currency}",
                color: CustomColor.primaryLightColor,
              ),
            ],
          ),
          verticalSpace(Dimensions.heightSize * 0.3),
          Row(
            children: [
              TitleHeading4Widget(
                text: Strings.balance,
                color: CustomColor.primaryLightColor,
              ),
              TitleHeading4Widget(
                text: ": ${userData.balance} ${userData.currency}",
                color: CustomColor.primaryLightColor,
              ),
            ],
          ),
        ],
      ),
    );
  }

  _chargeWidget(BuildContext context) {
    var userData = controller.stripeCardModel.data.userWallet;
    return 
       Container(
        child: Column(
          mainAxisAlignment: mainCenter,
          children: [
            Row(
              mainAxisAlignment: mainSpaceBet,
              children: [
                TitleHeading4Widget(text: Strings.totalCharge),
                Obx(()=>
                   TitleHeading4Widget(
                    text: "${controller.totalCharge.value} ${userData.currency}",
                    fontSize: Dimensions.headingTextSize5,
                  ),
                ),
              ],
            ),
            verticalSpace(Dimensions.heightSize * 0.4),
            Row(
              mainAxisAlignment: mainSpaceBet,
              children: [
                TitleHeading4Widget(text: Strings.TotalPay),
                Obx(()=>
                   TitleHeading4Widget(
                    text: "${controller.totalPay.value} ${userData.currency}",
                    fontSize: Dimensions.headingTextSize5,
                  ),
                ),
              ],
            ),
          ],
        ),
      
    );
  }

  _buttonWidget(BuildContext context) {
    var data = controller.stripeCardModel.data.cardCharge;
    return Container(
      margin: EdgeInsets.symmetric(vertical: Dimensions.paddingSize * 1.4),
      child: Obx(
        () => controller.isBuyCardLoading
            ? CustomLoadingAPI(
                color: CustomColor.primaryLightColor,
              )
            : PrimaryButton(
                title: Strings.confirm,
                onPressed: () {
                  double amount =
                      double.parse(controller.fundAmountController.text);
                  if (data.minLimit >= amount && data.maxLimit >= amount) {
                    controller.buyCardProcess(context);
                  } else {
                    CustomSnackBar.error(Strings.pleaseFollowTheLimit);
                  }
                },
                borderColor: CustomColor.primaryLightColor,
                buttonColor: CustomColor.primaryLightColor,
              ),
      ),
    );
  }
}
