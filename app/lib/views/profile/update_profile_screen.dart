import 'package:stripcard/widgets/appbar/appbar_widget.dart';
import '../../backend/utils/custom_loading_api.dart';
import '../../utils/basic_screen_import.dart';
import '../../controller/profile/update_profile_controller.dart';
import '../../widgets/inputs/country_picker_input_widget.dart';
import '../../widgets/inputs/primary_input_filed.dart';
import '../../widgets/others/image_picker/image_picker_widget.dart';

class UpdateProfileScreen extends StatelessWidget {
  UpdateProfileScreen({super.key});

  final controller = Get.put(UpdateProfileController());
  final profileFormKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        appBar: AppBarWidget(
          text: Strings.profile,
        ),
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

  _bodyWidget(BuildContext context) {
    return ListView(
      padding: EdgeInsets.symmetric(
        horizontal: Dimensions.marginSizeHorizontal * 0.9,
      ),
      physics: BouncingScrollPhysics(),
      children: [
        _imgWidget(context),
        _emailText(context),
        _inputWidget(context),
        _buttonWidget(context),
      ],
    );
  }

  _imgWidget(BuildContext context) {
    return ImagePickerWidget();
  }

  _inputWidget(BuildContext context) {
    return Form(
      key: profileFormKey,
      child: Column(
        crossAxisAlignment: crossStart,
        children: [
          Row(
            children: [
              Expanded(
                child: PrimaryInputWidget(
                  hint: Strings.enterFirstName,
                  label: Strings.firstName,
                  controller: controller.firstNameController,
                ),
              ),
              horizontalSpace(Dimensions.widthSize),
              Expanded(
                child: PrimaryInputWidget(
                  hint: Strings.enterLastName,
                  label: Strings.lastName,
                  controller: controller.lastNameController,
                ),
              ),
            ],
          ),
          verticalSpace(Dimensions.heightSize),
          CustomTitleHeadingWidget(
            text: Strings.country,
            style: CustomStyle.darkHeading4TextStyle.copyWith(
              fontWeight: FontWeight.w600,
              color: CustomColor.primaryLightTextColor,
            ),
          ),
          verticalSpace(Dimensions.heightSize * 0.5),
          CountryDropDown(
            selectMethod: controller.selectedCountry,
            itemsList: controller.userProfileModel.data.countries,
            onChanged: (value) {
              controller.selectedCountry.value = value!.name;
              controller.selectedCountryCode.value = value.mobileCode;

              print(controller.selectedCountry.value);
            },
          ),
          verticalSpace(Dimensions.heightSize),
          PrimaryInputWidget(
            keyboardInputType: TextInputType.number,
            hint: '${Strings.enter} ${Strings.phone}',
            label: Strings.phone,
            controller: controller.phoneNumberController,
            prefixIcon: Padding(
              padding: EdgeInsets.all(Dimensions.paddingSize * 0.7),
              child: TitleHeading3Widget(
                text:
                    '+${controller.selectedCountryCode.value.replaceAll('+', '')}    |',
              ),
            ),
          ),
          verticalSpace(Dimensions.heightSize),
          Row(
            children: [
              Expanded(
                child: PrimaryInputWidget(
                  hint: '${Strings.enter} ${Strings.address}',
                  label: Strings.address,
                  controller: controller.addressController,
                ),
              ),
              horizontalSpace(Dimensions.widthSize),
              Expanded(
                child: PrimaryInputWidget(
                  hint: Strings.enterSelectCity,
                  label: Strings.selectCity,
                  controller: controller.cityController,
                ),
              ),
            ],
          ),
          verticalSpace(Dimensions.heightSize),
          Row(
            children: [
              Expanded(
                child: PrimaryInputWidget(
                  hint: '${Strings.enter} ${Strings.state}',
                  label: Strings.state,
                  controller: controller.stateController,
                ),
              ),
              horizontalSpace(Dimensions.widthSize),
              Expanded(
                child: PrimaryInputWidget(
                  keyboardInputType: TextInputType.number,
                  hint: Strings.enterZipCode,
                  label: Strings.zipCode,
                  controller: controller.zipCodeController,
                ),
              ),
            ],
          ),
          verticalSpace(Dimensions.heightSize),
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
      child: Obx(
        () => controller.isUpdateLoading
            ? CustomLoadingAPI(
                color: CustomColor.primaryLightColor,
              )
            : PrimaryButton(
                title: Strings.updateProfile.tr,
                onPressed: () {
                  if (profileFormKey.currentState!.validate()) {
                    if (controller.imageController.isImagePathSet.value) {
                      controller.profileUpdateWithImageProcess();
                    } else {
                      controller.profileUpdateWithOutImageProcess();
                    }
                  }
                }),
      ),
    );
  }

  _emailText(BuildContext context) {
    return Container(
      alignment: Alignment.center,
      margin: EdgeInsets.only(
        bottom: Dimensions.marginSizeVertical,
      ),
      child: Column(
        children: [
          TitleHeading3Widget(
            text:
                "${controller.firstNameController.text} ${controller.lastNameController.text}",
            maxLines: 1,
            textOverflow: TextOverflow.ellipsis,
          ),
          TitleHeading4Widget(
            text: controller.emailController.text,
            maxLines: 1,
            textOverflow: TextOverflow.ellipsis,
          ),
        ],
      ),
    );
  }
}
