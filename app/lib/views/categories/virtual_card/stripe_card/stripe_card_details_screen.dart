
import '../../../../backend/utils/custom_loading_api.dart';
import '../../../../backend/utils/custom_switch_loading_api.dart';
import '../../../../controller/categories/virtual_card/stripe_card/stripe_details_controller.dart';
import '../../../../utils/basic_screen_import.dart';
import '../../../../widgets/appbar/appbar_widget.dart';
import '../../../../widgets/others/preview/details_row_widget.dart';


class StripeCardDetailsScreen extends StatelessWidget {
  StripeCardDetailsScreen({super.key});
  final controller = Get.put(StripeCardDetailsController());

  get payload => null;
  @override
  Widget build(
    BuildContext context,
  ) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        appBar: AppBarWidget(text: Strings.details),
        body: Obx(
          () => controller.isLoading
              ? CustomLoadingAPI(
                  color: CustomColor.primaryLightColor,
                )
              : _bodyWidget(context),
        ),
      ),
    );
  }

  _bodyWidget(
    BuildContext context,
  ) {
    return Padding(
      padding: EdgeInsets.symmetric(
        horizontal: Dimensions.paddingSize * 0.9,
      ),
      child: Column(
        children: [
        
          _cardDetailsWidget(context),
        ],
      ),
    );
  }


  _cardDetailsWidget(BuildContext context) {
    var myCards = controller.cardDetailsModel.data.cardDetails;

    return Container(
      margin: EdgeInsets.only(top: Dimensions.heightSize * 0.4),
      decoration: BoxDecoration(
          color: CustomColor.primaryLightColor,
          borderRadius: BorderRadius.circular(Dimensions.radius * 1.5)),
      child: Column(crossAxisAlignment: crossStart, children: [
        Padding(
          padding: EdgeInsets.only(
            top: Dimensions.paddingSize * 0.7,
            bottom: Dimensions.paddingSize * 0.3,
            left: Dimensions.paddingSize * 0.7,
            right: Dimensions.paddingSize * 0.7,
          ),
          child: TitleHeading3Widget(
            text: Strings.cardInformation,
            textAlign: TextAlign.left,
          ),
        ),
        Divider(
          thickness: 1,
          color: CustomColor.primaryLightScaffoldBackgroundColor,
        ),
        Padding(
          padding: EdgeInsets.only(
            top: Dimensions.paddingSize * 0.3,
            bottom: Dimensions.paddingSize * 0.6,
            left: Dimensions.paddingSize * 0.7,
            right: Dimensions.paddingSize * 0.7,
          ),
          child: Column(
            children: [
              DetailsRowWidget(
                variable: Strings.cardHolder,
                value: myCards.cardHolder,
              ),
              DetailsRowWidget(
                variable: Strings.currency,
                value: myCards.currency,
              ),
              DetailsRowWidget(
                variable: Strings.cardType,
                value: myCards.type,
              ),

              ///>>>>>>>> card plan

              Visibility(
                visible: controller.isShowSensitive.value == false,
                child: DetailsRowWidget(
                  variable: Strings.cardNumber,
                  value: myCards.cardPan,
                ),
              ),

              Visibility(
                visible: controller.isShowSensitive.value == true,
                child: DetailsRowWidget(
                  variable: Strings.cardNumber,
                  value: controller.cardPlan.value,
                ),
              ),

              ///>>>>>>>> card cvc
              Visibility(
                visible: controller.isShowSensitive.value == false,
                child: DetailsRowWidget(
                  variable: Strings.cvc,
                  value: myCards.cvv,
                ),
              ),
              Visibility(
                visible: controller.isShowSensitive.value == true,
                child: DetailsRowWidget(
                  variable: Strings.cvc,
                  value: controller.cardCVC.value,
                ),
              ),
              DetailsRowWidget(
                variable: Strings.expiration,
                value: "${myCards.expiryMonth}/${myCards.expiryYear}",
              ),
              DetailsRowWidget(
                variable: Strings.brand,
                value: myCards.brand,
              ),

              Row(
                mainAxisAlignment: mainSpaceBet,
                children: [
                  CustomTitleHeadingWidget(
                    text: Strings.revealDetails,
                    style: CustomStyle.darkHeading4TextStyle.copyWith(
                      color: CustomColor.primaryLightTextColor.withOpacity(0.4),
                    ),
                  ),
                  Obx(
                    () => controller.isLoading || controller.isSensitiveLoading
                        ? CustomSwitchLoading(
                            color: CustomColor.primaryLightColor,
                          )
                        : InkWell(
                            onTap: () {
                              controller.isShowSensitive.value =
                                  !controller.isShowSensitive.value;
                              if (controller.isShowSensitive.value == false) {
                                controller.getCardDetailsData();
                              } else {
                                controller.revealShowProcess();
                              }
                              print(controller.isShowSensitive.value);
                            },
                            child: Icon(
                              controller.isShowSensitive.value == false
                                  ? Icons.visibility_off
                                  : Icons.visibility,
                              color:
                                  CustomColor.primaryLightTextColor.withOpacity(0.4),
                            ),
                          ),
                  ),
                ],
              ),
              Row(
                mainAxisAlignment: mainSpaceBet,
                children: [
                  CustomTitleHeadingWidget(
                    text: Strings.freezeCard,
                    style: CustomStyle.darkHeading4TextStyle.copyWith(
                      color: CustomColor.primaryLightTextColor.withOpacity(0.4),
                    ),
                  ),
                  Obx(
                    () => controller.isCardStatusLoading
                        ? CustomSwitchLoading(
                            color: CustomColor.whiteColor,
                          )
                        : Switch(
                            activeColor: CustomColor.primaryLightTextColor
                                .withOpacity(0.6),
                            inactiveThumbColor:  CustomColor.primaryLightTextColor.withOpacity(0.6),
                            value: controller.isSelected.value,
                            onChanged: ((value) {
                              controller.isSelected.value =
                                  !controller.isSelected.value;
                              controller.cardToggle;
                            }),
                          ),
                  )
                ],
              )
            ],
          ),
        ),
      ]),
    );
  }
}
