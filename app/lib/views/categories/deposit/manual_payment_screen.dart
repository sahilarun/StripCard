import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/controller/navbar/deposit/deposit_controller.dart';
import 'package:flutter/material.dart';
import 'package:flutter_html/flutter_html.dart';
import 'package:get/get.dart';

import '../../../backend/utils/custom_snackbar.dart';
import '../../../controller/navbar/deposit/manual_gateway_controller.dart';
import '../../../language/strings.dart';
import '../../../routes/routes.dart';
import '../../../utils/custom_color.dart';
import '../../../utils/dimensions.dart';
import '../../../utils/size.dart';
import '../../../widgets/appbar/appbar_widget.dart';
import '../../../widgets/buttons/primary_button.dart';

class ManualPaymentScreen extends StatelessWidget {
  ManualPaymentScreen({super.key});

  final controller = Get.put(ManualPaymentController());
  final depositController = Get.put(DepositController());
  final formKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return WillPopScope(
      onWillPop: () async {
        Get.offAllNamed(Routes.dashboardScreen);
        return true;
      },
      child: Scaffold(
        appBar: AppBarWidget(
          text: Strings.manualPayment,
          onTap: () {
            Get.offAllNamed(Routes.dashboardScreen);
          },
        ),
        body: Obx(
          () =>
              controller.isLoading ? CustomLoadingAPI() : _bodyWidget(context),
        ),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    return Padding(
      padding: EdgeInsets.symmetric(
        horizontal: Dimensions.paddingSize * 0.7,
        vertical: Dimensions.paddingSize * 0.4,
      ),
      child: Form(
        key: formKey,
        child: ListView(
          physics: const BouncingScrollPhysics(),
          children: [
            _descriptionWidget(context),
            ...controller.inputFields.map((element) {
              return element;
            }).toList(),
            verticalSpace(Dimensions.heightSize * 0.7),
            _buttonWidget(context)
          ],
        ),
      ),
    );
  }

  _buttonWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.symmetric(vertical: Dimensions.marginSizeVertical),
      child: Obx(
        () => controller.isConfirmLoading
            ? CustomLoadingAPI(
                color: CustomColor.primaryLightColor,
              )
            : PrimaryButton(
                title: Strings.confirm.tr,
                onPressed: () {
                  if (formKey.currentState!.validate()) {
                    if (controller.listImagePath.isNotEmpty) {
                      controller.manualPaymentProcess(context);
                    } else {
                      CustomSnackBar.error(Strings.imagePathRequired);
                    }
                  }
                },
              ),
      ),
    );
  }

  _descriptionWidget(BuildContext context) {
    final data = controller.manualPaymentGetGatewayModel.data;
    print(data.details);
    return Container(
      padding: EdgeInsets.symmetric(
          vertical: Dimensions.paddingSize * 0.5,
          horizontal: Dimensions.paddingSize * 0.2),
      margin:
          EdgeInsets.symmetric(vertical: Dimensions.marginSizeVertical * 0.4),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(Dimensions.radius),
        color: CustomColor.primaryLightColor,
      ),
      child: Html(
        data: data.details,
      ),
    );
  }
}
