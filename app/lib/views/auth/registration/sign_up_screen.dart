import 'package:stripcard/backend/local_storage.dart';
import 'package:stripcard/backend/utils/custom_snackbar.dart';
import 'package:stripcard/widgets/inputs/auth_primary_input.dart';
import 'package:stripcard/widgets/inputs/auth_password_input.dart';
import '../../../backend/utils/custom_loading_api.dart';
import '../../../utils/basic_screen_import.dart';
import 'package:stripcard/widgets/buttons/custom_text_button.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../../controller/auth/registration/signup_controller.dart';
import '../../../widgets/others/checkbox/custom_check_box.dart';

class RegistrationScreen extends StatelessWidget {
  RegistrationScreen({super.key});

  final signUpFormKey = GlobalKey<FormState>();
  final controller = Get.put(RegistrationController());

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
      physics: const BouncingScrollPhysics(),
      child: SizedBox(
        height: height,
        width: width,
        child: ListView(
          physics: BouncingScrollPhysics(),
          children: [
            _logoWidget(
              context,
              logoHeight: height * 0.2,
            ),
            _bottomContainerWidget(context,
                height: height * 0.92,
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
      height: logoHeight,
      margin: EdgeInsets.only(top: Dimensions.marginSizeVertical),
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
            horizontal: Dimensions.marginSizeHorizontal * 0.55),
        decoration: BoxDecoration(
          color: CustomColor.primaryBGLightColor,
          borderRadius:
              BorderRadius.only(topLeft: borderRadius, topRight: borderRadius),
          boxShadow: [
            BoxShadow(
              color: CustomColor.primaryLightColor.withOpacity(0.015),
              spreadRadius: 7,
              blurRadius: 5,
              offset: const Offset(0, 0), // changes position of shadow
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
            text: Strings.signUpInformation.tr,
            color: CustomColor.whiteColor,
          ),
          verticalSpace(
            Dimensions.heightSize * 0.5,
          ),
          TitleHeading4Widget(
            fontSize: Dimensions.headingTextSize4 * 0.8,
            text: Strings.signUpDetails.tr,
            color: CustomColor.whiteColor,
          ),
        ],
      ),
    );
  }

  _inputAndForgotWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(
        top: Dimensions.marginSizeVertical * 0.8,
      ),
      child: Form(
        key: signUpFormKey,
        child: Column(
          crossAxisAlignment: crossStart,
          mainAxisSize: mainMin,
          children: [
            Row(
              children: [
                Expanded(
                  child: AuthPrimaryInputWidget(
                    controller: controller.firstNameController,
                    hint: Strings.enterName.tr,
                    label: Strings.firstName.tr,
                  ),
                ),
                horizontalSpace(Dimensions.widthSize),
                Expanded(
                  child: AuthPrimaryInputWidget(
                    controller: controller.lastNameController,
                    hint: Strings.enterName.tr,
                    label: Strings.lastName.tr,
                  ),
                ),
              ],
            ),
            verticalSpace(Dimensions.heightSize),
            AuthPrimaryInputWidget(
              keyboardInputType: TextInputType.emailAddress,
              controller: controller.emailAddressController,
              hint: Strings.enterEmailAddress.tr,
              label: Strings.emailAddress.tr,
            ),
            verticalSpace(Dimensions.heightSize),
            AuthPasswordInputWidget(
              controller: controller.passwordController,
              hint: Strings.enterPassword.tr,
              label: Strings.password.tr,
            ),
            Padding(
              padding: EdgeInsets.only(
                top: Dimensions.paddingSize * .5,
              ),
              child: FittedBox(
                child: Row(
                  crossAxisAlignment: crossStart,
                  children: [
                    CheckBoxWidget(
                      color: CustomColor.secondaryLightColor,
                      isChecked: controller.isSelected,
                      onChecked: (value) {
                        controller.isSelected.value = value;
                      },
                      title: Strings.agreedWith,
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  _buttonWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(
        bottom: Dimensions.marginSizeVertical,
        top: Dimensions.marginSizeVertical,
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
                    title: Strings.signUp.tr,
                    onPressed: () {
                      if (signUpFormKey.currentState!.validate()) {
                        if (controller.isSelected.value == false) {
                          controller.signUpProcess();
                        } else {
                          CustomSnackBar.error(Strings.pleaseCheckTerms);
                        }
                      }
                    },
                  ),
          ),
          verticalSpace(Dimensions.heightSize * 2.5),
          RichText(
            text: TextSpan(
              text: Strings.alreadyHaveAnAccount,
              style: GoogleFonts.inter(
                fontSize: Dimensions.headingTextSize5,
                color: CustomColor.whiteColor.withOpacity(
                  0.5,
                ),
                fontWeight: FontWeight.w500,
              ),
              children: [
                WidgetSpan(
                  child: CustomTextButton(
                    onPressed: () {
                      controller.onPressedSignIn();
                    },
                    text: Strings.richSignin,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
