import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/widgets/appbar/appbar_widget.dart';
import 'package:stripcard/widgets/inputs/password_input_widget.dart';
import '../../utils/basic_screen_import.dart';
import '../../controller/drawer/change_password_controller.dart';

class ChangePasswordScreen extends StatelessWidget {
  ChangePasswordScreen({super.key});
  final controller = Get.put(PasswordController());
  final passwordFormKey = GlobalKey<FormState>();
  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        appBar: AppBarWidget(text: Strings.changePassword),
        body: _bodyWidget(context),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    return ListView(
      padding: EdgeInsets.symmetric(
          horizontal: Dimensions.marginSizeHorizontal * 0.9),
      physics: BouncingScrollPhysics(),
      children: [
        _inputWidget(context),
        _buttonWidget(context),
      ],
    );
  }

  _inputWidget(BuildContext context) {
    return Form(
      key: passwordFormKey,
      child: Column(
        children: [
          verticalSpace(Dimensions.heightSize * 2),
          PasswordInputWidget(
            controller: controller.oldPasswordController,
            hint: Strings.enterOldPassword,
            label: Strings.oldPassword,
          ),
          verticalSpace(Dimensions.heightSize),
          PasswordInputWidget(
            controller: controller.newPasswordController,
            hint: Strings.enterNewPassword,
            label: Strings.newPassword,
          ),
          verticalSpace(Dimensions.heightSize),
          PasswordInputWidget(
            controller: controller.confirmPasswordController,
            hint: Strings.enterConfirmPassword,
            label: Strings.confirmPassword,
          ),
        ],
      ),
    );
  }

  _buttonWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(top: Dimensions.marginSizeVertical * 2),
      child: Obx(
        () => controller.isLoading
            ? CustomLoadingAPI(
                color: CustomColor.primaryLightColor,
              )
            : PrimaryButton(
                onPressed: () {
                  if (passwordFormKey.currentState!.validate()) {
                    controller.updatePasswordProcess();
                  }
                },
                title: Strings.changePassword,
              ),
      ),
    );
  }
}
