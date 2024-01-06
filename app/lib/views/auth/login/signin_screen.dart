import 'package:stripcard/backend/local_storage.dart';
import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/widgets/buttons/custom_text_button.dart';
import 'package:stripcard/widgets/others/glass_widget.dart';
import '../../../utils/basic_screen_import.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../../controller/auth/login/signin_controller.dart';
import '../../../widgets/inputs/auth_primary_input.dart';
import '../../../widgets/inputs/forgot_password_input.dart';
import '../../../widgets/inputs/auth_password_input.dart';

class SignInScreen extends StatelessWidget {
  SignInScreen({super.key});

  final controller = Get.put(SignInController());
  final phoneNumberFormKey = GlobalKey<FormState>();
  final signInFormKey = GlobalKey<FormState>();
  final forgotPasswordFormKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        body: _bodyWidget(context),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    final height = MediaQuery.of(context).size.height;
    final width = MediaQuery.of(context).size.width;
    return SingleChildScrollView(
      padding: EdgeInsets.symmetric(
        horizontal: Dimensions.paddingSize * 0.05,
      ),
      physics: const BouncingScrollPhysics(),
      child: SizedBox(
        height: height,
        width: width,
        child: ListView(
          physics: BouncingScrollPhysics(),
          children: [
            _logoWidget(
              context,
              logoHeight: height * 0.3,
            ),
            _bottomContainerWidget(context,
                height: height * 0.8,
                child: Column(
                  children: [
                    _titleAndSubtitleWidget(context),
                    _inputAndForgotWidget(context),
                    _buttonWidget(context),
                  ],
                ))
          ],
        ),
      ),
    );
  }

  _logoWidget(BuildContext context, {required double logoHeight}) {
    return Container(
      margin: EdgeInsets.only(top: Dimensions.marginSizeVertical * 1.2),
      height: logoHeight,
      padding: EdgeInsets.only(
        top: Dimensions.paddingSize * 3,
        bottom: Dimensions.paddingSize * 1.5,
      ),
      child: Center(
        child: Image.network(
        LocalStorage.getBasicImage(),
          width: MediaQuery.of(context).size.width * 0.5,
          height: MediaQuery.of(context).size.height * 0.1,
        ),
      ),
    );
  }

  _bottomContainerWidget(BuildContext context,
      {required Widget child, required double height}) {
    Radius borderRadius = const Radius.circular(20);
    return Container(
        height: height,
        margin: EdgeInsets.symmetric(
            horizontal: Dimensions.marginSizeHorizontal * 0.5),
        decoration: BoxDecoration(
          color: CustomColor.primaryBGLightColor,
          borderRadius:
              BorderRadius.only(topLeft: borderRadius, topRight: borderRadius),
          boxShadow: [
            BoxShadow(
              color: CustomColor.primaryLightColor.withOpacity(0.015),
              spreadRadius: 7,
              blurRadius: 5,
              offset: const Offset(0, 0),
              // changes position of shadow
            ),
          ],
        ),
        padding: EdgeInsets.all(Dimensions.paddingSize),
        child: child);
  }

  _titleAndSubtitleWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.symmetric(
        vertical: Dimensions.marginSizeVertical * 0.5,
      ),
      child: Column(
        crossAxisAlignment: crossStart,
        children: [
          TitleHeading2Widget(
            text: Strings.signinInformation.tr,
            color: CustomColor.whiteColor,
          ),
          verticalSpace(
            Dimensions.heightSize * 0.5,
          ),
          TitleHeading4Widget(
            fontSize: Dimensions.headingTextSize4 * 0.8,
            text: Strings.signInInformationSubtitle.tr,
            color: CustomColor.whiteColor,
          ),
        ],
      ),
    );
  }

  _inputAndForgotWidget(BuildContext context) {
    return Form(
      key: signInFormKey,
      child: Column(
        crossAxisAlignment: crossEnd,
        children: [
          verticalSpace(Dimensions.heightSize),
          AuthPrimaryInputWidget(
            keyboardInputType: TextInputType.emailAddress,
            controller: controller.emailAddressController,
            hint: Strings.enterEmailAddress,
            label: Strings.emailAddress,
          ),
          verticalSpace(
            Dimensions.heightSize * 0.7,
          ),
          AuthPasswordInputWidget(
            controller: controller.passwordController,
            hint: Strings.enterPassword,
            label: Strings.password,
          ),
          verticalSpace(Dimensions.heightSize),
          InkWell(
            onTap: () => _openDialogue(context),
            child: TitleHeading4Widget(
              fontWeight: FontWeight.w600,
              fontSize: Dimensions.headingTextSize5,
              color: CustomColor.whiteColor,
              text: '${Strings.forgotPasswordd}?',
            ),
          ),
        ],
      ),
    );
  }

  _buttonWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(
        top: Dimensions.marginSizeVertical,
        bottom: Dimensions.marginSizeVertical,
      ),
      child: Column(
        mainAxisAlignment: mainCenter,
        children: [
          Obx(
            () => controller.isLoading
                ? CustomLoadingAPI()
                : PrimaryButton(
                  borderColor: CustomColor.secondaryLightColor,
                  buttonColor: CustomColor.secondaryLightColor,
                    title: Strings.signIn,
                    onPressed: () {
                      if (signInFormKey.currentState!.validate()) {
                        controller.loginProcess();
                      }
                    },
                    buttonTextColor: CustomColor.whiteColor,
                  ),
          ),
          verticalSpace(Dimensions.heightSize * 3.5),
          RichText(
            text: TextSpan(
              text: Strings.haveAccount,
              style: GoogleFonts.inter(
                fontSize: Dimensions.headingTextSize5,
                color: CustomColor.whiteColor.withOpacity(0.6),
                fontWeight: FontWeight.w500,
              ),
              children: [
                WidgetSpan(
                  child: CustomTextButton(
                    onPressed: () {
                      controller.onPressedSignUP();
                    },
                    text: Strings.richSignUp,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  _openDialogue(
    BuildContext context,
  ) {
    return showDialog(
        context: context,
        builder: (_) => AlertDialog(
              backgroundColor: Colors.transparent,
              alignment: Alignment.center,
              insetPadding: EdgeInsets.all(Dimensions.paddingSize * 0.3),
              contentPadding: EdgeInsets.zero,
              clipBehavior: Clip.antiAliasWithSaveLayer,
              shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(20)),
              content: Builder(
                builder: (context) {
                  var width = MediaQuery.of(context).size.width;
                  return Stack(
                    children: [
                      Container(
                        width: width * 0.84,
                        margin: EdgeInsets.all(Dimensions.paddingSize * 0.5),
                        padding: EdgeInsets.all(Dimensions.paddingSize * 0.9),
                        decoration: BoxDecoration(
                          color: CustomColor.whiteColor,
                          borderRadius:
                              BorderRadius.circular(Dimensions.radius * 1.4),
                        ),
                        child: Column(
                          mainAxisSize: MainAxisSize.min,
                          crossAxisAlignment: crossStart,
                          children: [
                            SizedBox(height: Dimensions.heightSize * 2),
                            const TitleHeading2Widget(
                              text: Strings.forgotPassword,
                              color: CustomColor.thirdLightTextColor,
                            ),
                            verticalSpace(Dimensions.heightSize * 0.5),
                            TitleHeading4Widget(
                              text: Strings.pleaseEnterYourRegister,
                              color: CustomColor.thirdLightTextColor
                                  .withOpacity(0.7),
                            ),
                            SizedBox(height: Dimensions.heightSize * 1),
                            Form(
                              key: forgotPasswordFormKey,
                              child: ForgotInputWidget(
                                
                                keyboardInputType: TextInputType.emailAddress,
                                controller:
                                    controller.forgetEmailAddressController,
                                hint: Strings.enterEmailAddress,
                                label: Strings.emailAddress,
                              ),
                            ),
                            verticalSpace(Dimensions.heightSize),
                            Obx(
                              () => controller.isForgetPasswordLoading
                                  ? CustomLoadingAPI(
                                      color: CustomColor.primaryLightColor,
                                    )
                                  : PrimaryButton(
                                    buttonColor:CustomColor.primaryBGLightColor,
                                      height: Dimensions.buttonHeight * 0.8,
                                      title: Strings.forgetPassword.tr,
                                      onPressed: () {
                                        if (forgotPasswordFormKey.currentState!
                                            .validate()) {
                                          controller
                                              .forgetPasswordEmailProcess();
                                        }
                                      },
                                       borderColor:
                                          CustomColor.primaryBGLightColor,
                                    ),
                            ),
                          ],
                        ),
                      ),
                      Positioned(
                        top: 0,
                        right: 0,
                        child: GestureDetector(
                            onTap: () {
                              Get.back();
                            },
                            child: const CircleAvatar(
                              backgroundColor: CustomColor.primaryBGLightColor,
                              child: Icon(
                                Icons.close,
                                color: CustomColor.whiteColor,
                              ),
                            )),
                      ),
                    ],
                  );
                },
              ),
            ).customGlassWidget(
              blurY: 1,
              blurX: 1,
            ));
  }
}
