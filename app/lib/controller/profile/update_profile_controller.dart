import 'dart:io';

import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';

import '../../backend/model/common/common_success_model.dart';
import '../../backend/model/profile/profile_info_model.dart';
import '../../backend/services/api_services.dart';
import '../../routes/routes.dart';
import '../../widgets/others/image_picker/image_picker.dart';

class UpdateProfileController extends GetxController {
  final firstNameController = TextEditingController();
  final lastNameController = TextEditingController();
  final emailController = TextEditingController();
  final countryController = TextEditingController();
  final cityController = TextEditingController();
  final zipCodeController = TextEditingController();
  final addressController = TextEditingController();
  final phoneNumberController = TextEditingController();
  final stateController = TextEditingController();
  final imageController = Get.put(InputImageController());

  RxString selectedCountryCode = ''.obs;
  RxString selectedCountry = ''.obs;
  RxString selectedCity = ''.obs;

  File? image;
  RxBool haveImage = false.obs;
  final picker = ImagePicker();

  @override
  void onInit() {
    getUserProfileData();
    super.onInit();
  }

  final _isLoading = false.obs;

  bool get isLoading => _isLoading.value;
  final _isUpdateLoading = false.obs;

  bool get isUpdateLoading => _isUpdateLoading.value;

  late ProfileModel _userProfileModel;

  ProfileModel get userProfileModel => _userProfileModel;

  Future<ProfileModel> getUserProfileData() async {
    _isLoading.value = true;
    update();

    await ApiServices.userProfileApi().then((value) {
      _userProfileModel = value!;
      final data = _userProfileModel.data.user;
      firstNameController.text = data.firstname;
      lastNameController.text = data.lastname;
      emailController.text = data.email;
      countryController.text = data.address.country;
      cityController.text = data.address.city;
      zipCodeController.text = data.address.zip;
      addressController.text = data.address.address;
      phoneNumberController.text = data.mobile;
      stateController.text = data.address.state;
      selectedCountry.value = data.address.country;
      selectedCity.value = data.address.city;
      getPhoneCodeAndCountry(data);

      update();
    }).catchError((onError) {
      log.e(onError);
    });

    _isLoading.value = false;
    update();
    return _userProfileModel;
  }

  RxInt selectValue = 0.obs;

  late CommonSuccessModel _profileUpdateModel;

  CommonSuccessModel get profileUpdateModel => _profileUpdateModel;

  Future<CommonSuccessModel> profileUpdateWithOutImageProcess() async {
    _isUpdateLoading.value = true;
    update();

    Map<String, dynamic> inputBody = {
      'firstname': firstNameController.text,
      'lastname': lastNameController.text,
      'country': selectedCountry.value,
      'phone_code': selectedCountryCode.value,
      'phone': phoneNumberController.text,
      'state': stateController.text,
      'city': cityController.text,
      'zip_code': zipCodeController.text,
      'address': addressController.text,
    };

    await ApiServices.updateProfileWithoutImageApi(body: inputBody)
        .then((value) {
      _profileUpdateModel = value!;
      Get.offAllNamed(Routes.bottomNavBarScreen);
      update();
    }).catchError((onError) {
      log.e(onError);
    });

    _isUpdateLoading.value = false;
    update();
    return _profileUpdateModel;
  }

  // Profile update process with image
  Future<CommonSuccessModel> profileUpdateWithImageProcess() async {
    _isUpdateLoading.value = true;
    update();

    Map<String, String> inputBody = {
      'firstname': firstNameController.text,
      'lastname': lastNameController.text,
      'country': countryController.text,
      'phone_code': selectedCountryCode.value,
      'phone': phoneNumberController.text,
      'state': stateController.text,
      'city': cityController.text,
      'zip_code': zipCodeController.text,
      'address': addressController.text,
    };

    await ApiServices.updateProfileWithImageApi(
      body: inputBody,
      filepath: imageController.imagePath.value,
    ).then((value) {
      _profileUpdateModel = value!;
      Get.offAllNamed(Routes.bottomNavBarScreen);
      update();
    }).catchError((onError) {
      log.e(onError);
    });

    _isUpdateLoading.value = false;
    update();
    return _profileUpdateModel;
  }



  void gotoNavigation() {
    Get.offAllNamed(Routes.bottomNavBarScreen);
  }

  void getPhoneCodeAndCountry(data) {
    if (data.mobileCode.isNotEmpty) {
      selectedCountryCode.value = data.mobileCode;
    } else {
      selectedCountryCode.value =
          _userProfileModel.data.countries.first.mobileCode;
    }
    if (data.address.country.isNotEmpty) {
      selectedCountry.value = data.address.country;
    } else {
      selectedCountry.value = _userProfileModel.data.countries.first.name;
    }
  }
}
