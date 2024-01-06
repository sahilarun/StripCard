import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../../backend/local_storage.dart';
import '../../../backend/utils/custom_snackbar.dart';
import '../../../controller/navbar/deposit/deposit_controller.dart';
import '../../../widgets/appbar/appbar_widget.dart';
import '../../../widgets/dropdown/deposit_method_drop_down.dart';
import '../../../widgets/others/limit_widget.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../widgets/inputs/input_with_text.dart';

class DepositScreen extends StatelessWidget {
  DepositScreen({super.key});

  final controller = Get.put(DepositController());

  // final depositFormKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
        mobileScaffold: Scaffold(
            appBar: AppBarWidget(text: Strings.deposit),
            body: Obx(
              () => controller.isLoading
                  ? CustomLoadingAPI()
                  : _bodyWidget(context),
            )));
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
    return Column(
      children: [
        InputWithText(
          controller: controller.amountController,
          hint: Strings.zero00,
          label: Strings.amount,
          suffixText: LocalStorage.getBaseCurrency() ?? 'USD',
        ),
        Column(
          crossAxisAlignment: crossStart,
          children: [
            verticalSpace(Dimensions.heightSize),
            TitleHeading4Widget(
              text: Strings.depositMethod,
              fontWeight: FontWeight.w600,
            ),
            verticalSpace(Dimensions.heightSize * 0.6),
            DepositMethodDropDown(
              itemsList: controller.currencyList,
              selectMethod: controller.selectedCurrencyName,
              onChanged: (currency) {
                controller.selectedCurrencyName.value = currency!.name;
                controller.selectedCurrencyAlias.value = currency.alias;
                controller.selectedCurrencyType.value =
                    currency.type.toString();
                controller.limitMin.value = currency.minLimit / currency.rate;
                controller.limitMax.value = currency.maxLimit / currency.rate;
                controller.fee.value = currency.fixedCharge.toDouble();
                controller.rate.value = currency.rate;
                controller.percentCharge.value =
                    currency.percentCharge.toDouble();
                controller.code.value = currency.currencyCode;
                print(controller.selectedCurrencyAlias.value);
                print(controller.selectedCurrencyType.value);
              },
            ),
            limitWidget(
              fee: "${controller.fee} ${controller.baseCurrency.value}",
              limit:
                  '${controller.limitMin.toStringAsFixed(2)} ${controller.baseCurrency.value} - ${controller.limitMax.toStringAsFixed(2)} ${controller.baseCurrency.value}',
            ),
            Text(
              "${Strings.exchangeRate}: ${controller.baseCurrencyRate} ${controller.baseCurrency.value} = ${controller.rate.value} ${controller.code.value}",
              textAlign: TextAlign.left,
              style: GoogleFonts.inter(
                fontSize: Dimensions.headingTextSize5,
                fontWeight: FontWeight.w500,
                color: CustomColor.primaryLightTextColor,
              ),
            ),
          ],
        ),
      ],
    );
  }

  _buttonWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.symmetric(
        vertical: Dimensions.marginSizeVertical * 1.6,
      ),
      child: PrimaryButton(
        title: Strings.proceed,
        onPressed: () {
          controller.amount.value =
              double.parse(controller.amountController.text);
          if (controller.amountController.text.isNotEmpty) {
            if (controller.limitMin.value <= controller.amount.value &&
                controller.limitMax.value >= controller.amount.value) {
              Get.toNamed(Routes.depositPreviewScreen);
            } else {
              CustomSnackBar.error(Strings.pleaseFollowTheLimit);
            }
          } else {
            CustomSnackBar.error(Strings.pleaseFillTheAmount);
          }
        },
      ),
    );
  }
}
