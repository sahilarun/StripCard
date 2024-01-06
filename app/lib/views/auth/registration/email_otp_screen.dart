import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/controller/auth/registration/otp_email_controler.dart';
import 'package:pin_code_fields/pin_code_fields.dart';
import 'package:stripcard/controller/auth/registration/signup_controller.dart';
import '../../../backend/local_storage.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../widgets/appbar/back_button.dart';

class EmailOtpScreen extends StatelessWidget {
  EmailOtpScreen({Key? key}) : super(key: key);
  final controller = Get.put(EmailOtpController());
  final signUpController = Get.put(RegistrationController());
  final emailOtpFormKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        backgroundColor: Theme.of(context).scaffoldBackgroundColor,
        appBar: AppBar(
          elevation: 0,
          backgroundColor: CustomColor.primaryLightScaffoldBackgroundColor,
          leading: const BackButtonWidget(),
        ),
        body: _bodyWidget(context),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    return Obx(
      () => ListView(
        padding: EdgeInsets.all(Dimensions.paddingSize),
        physics: const BouncingScrollPhysics(),
        children: [
          _titleAndSubtitleWidget(context),
          _inputWidget(context),
          _timerWidget(context),
          controller.secondsRemaining.value == 0
              ? verticalSpace(Dimensions.heightSize * 1.7)
              : Container(),
          _submitButtonWidget(context),
        ],
      ),
    );
  }

  _titleAndSubtitleWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(
        top: Dimensions.marginSizeVertical * 3,
      ),
      child: Column(
        crossAxisAlignment: crossStart,
        children: [
          TitleHeading2Widget(
            text: Strings.oTPVerification,
            color: CustomColor.whiteColor,
            fontSize: Dimensions.headingTextSize2,
            fontWeight: FontWeight.w700,
          ),
          verticalSpace(Dimensions.heightSize * 0.7),
          TitleHeading4Widget(
            text:
                "${Strings.enterTheOTPCodeSendTo.tr} ${LocalStorage.getEmail()}",
            color: CustomColor.primaryLightTextColor.withOpacity(
              0.6,
            ),
          ),
        ],
      ),
    );
  }

  _inputWidget(BuildContext context) {
    return Form(
      key: emailOtpFormKey,
      child: Column(
        mainAxisAlignment: mainCenter,
        children: [
          Padding(
            padding: EdgeInsets.only(
              top: Dimensions.heightSize * 5,
            ),
            child: PinCodeTextField(
              cursorColor: CustomColor.primaryLightTextColor,
              controller: controller.emailOtpInputController,
              appContext: context,
              length: 6,
              obscureText: false,
              keyboardType: TextInputType.number,
              textStyle:
                  const TextStyle(color: CustomColor.primaryLightTextColor),
              animationType: AnimationType.fade,
              validator: (v) {
                if (v!.length < 3) {
                  return Strings.pleaseFillOutTheField;
                } else {
                  return null;
                }
              },
              pinTheme: PinTheme(
                  shape: PinCodeFieldShape.box,
                  borderRadius: BorderRadius.circular(Dimensions.radius * 0.7),
                  selectedColor: CustomColor.primaryBGLightColor,
                  activeColor: CustomColor.primaryBGLightColor,
                  inactiveColor: CustomColor.primaryLightTextColor,
                  fieldHeight: 46.h,
                  fieldWidth: 48.w,
                  errorBorderColor: CustomColor.redColor,
                  activeFillColor: CustomColor.transparent,
                  borderWidth: 2,
                  fieldOuterPadding: const EdgeInsets.all(1)),
              onChanged: (value) {
                controller.changeCurrentText(value);
              },
            ),
          ),
        ],
      ),
    );
  }

  _timerWidget(BuildContext context) {
    return Visibility(
      visible: controller.secondsRemaining.value != 0,
      child: Container(
        margin: EdgeInsets.symmetric(vertical: Dimensions.marginSizeVertical),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Icon(
              Icons.access_time_outlined,
              color: CustomColor.primaryLightTextColor,
            ),
            SizedBox(width: Dimensions.widthSize * 0.4),
            CustomTitleHeadingWidget(
              text: controller.secondsRemaining.value >= 0 &&
                      controller.secondsRemaining.value <= 9
                  ? '00:0${controller.secondsRemaining.value}'
                  : '00:${controller.secondsRemaining.value}',
              style: CustomStyle.darkHeading4TextStyle.copyWith(
                fontWeight: FontWeight.w600,
                color: CustomColor.primaryLightTextColor,
              ),
            ),
          ],
        ),
      ),
    );
  }

  _submitButtonWidget(BuildContext context) {
    return Column(
      children: [
        Obx(
          () => controller.isLoading
              ? CustomLoadingAPI()
              : PrimaryButton(
                  title: Strings.submit,
                  buttonColor: CustomColor.primaryBGLightColor,
                  borderColor: CustomColor.primaryBGLightColor,
                  onPressed: () {
                    if (emailOtpFormKey.currentState!.validate()) {
                      controller.mailVerifyCodeProcess(context);
                    }
                  },
                ),
        ),
        verticalSpace(Dimensions.heightSize * 2),
        Visibility(
          visible: controller.enableResend.value,
          child: InkWell(
            onTap: () {
              controller.resendCode();
              controller.resendVerifyCodeProcess();
            },
            child: CustomTitleHeadingWidget(
              text: Strings.resendCode,
              style: CustomStyle.darkHeading4TextStyle.copyWith(
                fontSize: Dimensions.headingTextSize3,
                color: CustomColor.primaryBGLightColor,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ),
      ],
    );
  }
}
