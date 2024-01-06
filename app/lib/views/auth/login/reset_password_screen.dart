import 'package:stripcard/widgets/inputs/password_input_widget.dart';
import '../../../backend/utils/custom_loading_api.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../controller/auth/login/reset_password_controller.dart';
import '../../../widgets/appbar/back_button.dart';

class ResetPasswordScreen extends StatelessWidget {
  ResetPasswordScreen({Key? key}) : super(key: key);
  final controller = Get.put(ResetPasswordController());
  final resetFormKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(  
      mobileScaffold: WillPopScope(
        onWillPop: () async {
          Get.offAllNamed(Routes.signInScreen);
          return true;
        },
        child: Scaffold(
          appBar: AppBar(
            elevation: 0,
            backgroundColor: CustomColor.primaryLightScaffoldBackgroundColor,
            leading: BackButtonWidget(
              onTap: () {
                Get.toNamed(Routes.signInScreen);
              },
            ),
          ),
          body: _bodyWidget(context),
        ),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    return ListView(
      padding: EdgeInsets.all(Dimensions.paddingSize),
      physics: const BouncingScrollPhysics(),
      children: [
        _titleAndSubtitleWidget(context),
        _inputWidget(context),
        _resetButtonWidget(context),
      ],
    );
  }

  _titleAndSubtitleWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(
        top: Dimensions.marginSizeVertical * 0.1,
      ),
      child: Column(
        crossAxisAlignment: crossStart,
        children: [
          TitleHeading2Widget(text: Strings.resetPassword.tr,
           color: CustomColor.primaryLightTextColor,
            fontSize: Dimensions.headingTextSize2,
            fontWeight: FontWeight.w700,
          ),
          verticalSpace(Dimensions.heightSize * 0.7),
          TitleHeading4Widget(
            text: Strings.resetPasswordDetails.tr,
             color: CustomColor.primaryLightTextColor.withOpacity(0.6),
            fontSize: Dimensions.headingTextSize4,
            fontWeight: FontWeight.w400,
          )
        ],
      ),
    );
  }

  _inputWidget(BuildContext context) {
    return Container(
      margin:
          EdgeInsets.symmetric(vertical: Dimensions.marginSizeVertical * 1.4),
      child: Form(
        key: resetFormKey,
        child: Column(
          mainAxisAlignment: mainCenter,
          children: [
            PasswordInputWidget(
              controller: controller.newPasswordController,
              hint: Strings.enterNewPassword.tr,
              label: Strings.newPassword.tr,
            ),
            verticalSpace(Dimensions.heightSize),
            PasswordInputWidget(
              controller: controller.confirmPasswordController,
              hint: Strings.enterConfirmPassword.tr,
              label: Strings.confirmPassword.tr,
            ),
          ],
        ),
      ),
    );
  }

  _resetButtonWidget(BuildContext context) {
    return Column(
      children: [
        Obx(
          () => controller.isLoading
              ? CustomLoadingAPI(
                  color: CustomColor.primaryBGLightColor,
                )
              : PrimaryButton(
                borderColor: CustomColor.primaryBGLightColor,
                buttonColor: CustomColor.primaryBGLightColor,
                  title: Strings.resetPassword.tr,
                  onPressed: () {
                    if (resetFormKey.currentState!.validate()) {
                      controller.changePasswordProcess(context);
                    }
                    ;
                  },
                ),
        ),
        verticalSpace(Dimensions.heightSize * 2),
      ],
    );
  }
}
