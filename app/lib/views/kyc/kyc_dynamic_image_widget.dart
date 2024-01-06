import 'dart:io';

import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';

import '../../backend/utils/custom_snackbar.dart';
import '../../controller/drawer/kyc_controller.dart';
import '../../utils/custom_color.dart';
import '../../utils/dimensions.dart';

File? imageFile;

class KycImageWidget extends StatelessWidget {
  KycImageWidget({Key? key, required this.labelName, required this.fieldName})
      : super(key: key);

  final controller = Get.put(KycController());
  final String labelName;
  final String fieldName;

  Future pickImage(imageSource) async {
    try {
      final image =
          await ImagePicker().pickImage(source: imageSource, imageQuality: 50);
      if (image == null) return;

      imageFile = File(image.path);

      if (controller.listFieldName.isNotEmpty) {
        if (controller.listFieldName.contains(fieldName)) {
          int itemIndex = controller.listFieldName.indexOf(fieldName);
          controller.listFieldName[itemIndex] = fieldName;
          controller.listImagePath[itemIndex] = imageFile!.path;
        } else {
          controller.listImagePath.add(imageFile!.path);
          controller.listFieldName.add(fieldName);
        }
      } else {
        controller.listImagePath.add(imageFile!.path);
        controller.listFieldName.add(fieldName);
      }

      Get.back();
      CustomSnackBar.success('$labelName Added');
    } on PlatformException catch (e) {
      CustomSnackBar.error('Error: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () {
        showModalBottomSheet(
          context: context,
          builder: (context) => imagePickerBottomSheetWidget(context),
        );
      },
      child: Container(
        // height: MediaQuery.of(context).size.height * 0.10,
        padding: const EdgeInsets.all(10),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(Dimensions.radius * 2),
          border: Border.all(
            width: 1,
            color: CustomColor.primaryLightTextColor.withOpacity(0.2),
          ),
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Icon(
              Icons.file_upload,
              color: CustomColor.primaryLightTextColor,
            ),
            SizedBox(
              width: Dimensions.widthSize * 0.5,
            ),
            Text(
              labelName,
              style: TextStyle(
                color: CustomColor.primaryLightTextColor,
                fontSize: Dimensions.headingTextSize6,
                fontWeight: FontWeight.w200,
              ),
              // overflow: TextOverflow.ellipsis,
              // maxLines: 2,
            )
          ],
        ),
      ),
    );
  }

  imagePickerBottomSheetWidget(BuildContext context) {
    return Container(
      width: double.infinity,
      height: MediaQuery.of(context).size.height * 0.15,
      margin: EdgeInsets.all(Dimensions.marginSizeVertical * 0.5),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Padding(
            padding: EdgeInsets.all(Dimensions.paddingSize),
            child: IconButton(
                onPressed: () {
                  pickImage(ImageSource.gallery);
                },
                icon: const Icon(
                  Icons.image,
                  color: CustomColor.primaryBGLightColor,
                  size: 50,
                )),
          ),
          Padding(
            padding: EdgeInsets.all(Dimensions.paddingSize),
            child: IconButton(
                onPressed: () {
                  pickImage(ImageSource.camera);
                },
                icon: const Icon(
                  Icons.camera,
                  color: CustomColor.primaryBGLightColor,
                  size: 50,
                )),
          ),
        ],
      ),
    );
  }
}
