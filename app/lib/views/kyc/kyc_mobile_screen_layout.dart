import 'package:stripcard/backend/local_storage.dart';
import 'package:stripcard/utils/basic_screen_import.dart';
import '../../backend/utils/custom_loading_api.dart';
import '../../controller/drawer/kyc_controller.dart';
import '../../widgets/appbar/appbar_widget.dart';

class KycMobileScreenLayout extends StatelessWidget {
  KycMobileScreenLayout({
    Key? key,
    required this.controller,
  }) : super(key: key);

  final KycController controller;
  final formKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBarWidget(text: Strings.kycVerification),
      body: Obx(() {
        return controller.isLoading
            ? const CustomLoadingAPI(
                color: CustomColor.primaryLightColor,
              )
            : _bodyWidget(context);
      }),
    );
  }

  // body widget
  _bodyWidget(BuildContext context) {
    return Column(
      children: [
        _containerWidget(context),
      ],
    );
  }

  _containerWidget(BuildContext context) {
    return Expanded(
      child: Container(
        padding: EdgeInsets.only(
            left: Dimensions.paddingSize, right: Dimensions.paddingSize),
        
        child: ListView(
          children: [
            _inputWidget(context),
            //_statusWidget(context),
            _buttonWidget(context),
          ],
        ),
      ),
    );
  }

  // input widgets
  _inputWidget(BuildContext context) {
    return Container(
      height: 450.h,
      margin: EdgeInsets.only(top: Dimensions.paddingSize * 1.5),
      child: Form(
        key: formKey,
        child: Column(
          crossAxisAlignment: crossStart,
          children: [
            controller.kycInfoModel.data.kycStatus == 2
                ? Container(
                    decoration: BoxDecoration(
                        color: CustomColor.primaryBGLightColor,
                        borderRadius: BorderRadius.circular(Dimensions.radius)),
                    alignment: Alignment.center,
                    padding: EdgeInsets.symmetric(
                        vertical: Dimensions.paddingSize,
                        horizontal: Dimensions.paddingSize * 1.5),
                    child: TitleHeading1Widget(
                      text: Strings.pending,
                    ),
                  )
                : controller.kycInfoModel.data.kycStatus == 1
                    ? Container(
                        decoration: BoxDecoration(
                            color: CustomColor.primaryBGLightColor,
                            borderRadius:
                                BorderRadius.circular(Dimensions.radius)),
                        alignment: Alignment.center,
                        padding: EdgeInsets.symmetric(
                            vertical: Dimensions.paddingSize,
                            horizontal: Dimensions.paddingSize * 1.5),
                        child: TitleHeading1Widget(
                          text: Strings.verified,
                        ),
                      )
                    : Column(
                        children: [
                          ...controller.inputFields.map((element) {
                            return element;
                          }).toList(),
                        ],
                      ),
            SizedBox(
              height: Dimensions.marginBetweenInputTitleAndBox * 2,
            ),
          ],
        ),
      ),
    );
  }

  // button widget
  _buttonWidget(BuildContext context) {
    var data = LocalStorage.getKyc();
    return data == 0 || data == 3
        ? PrimaryButton(
            title: Strings.submit.tr,
            onPressed: () {
              if (formKey.currentState!.validate()) {}
              controller.submitKycProcess(context: context);
            },
          )
        : SizedBox();
  }

  // _statusWidget(BuildContext context) {
  //   var data = controller.kycInfoModel.data.kycStatus;
  //   return Column(
  //     children: [
  //       Visibility(
  //         visible: data == 2,
  //         child: Container(
  //           decoration: BoxDecoration(
  //               color: CustomColor.whiteColor,
  //               borderRadius: BorderRadius.circular(Dimensions.radius)),
  //           alignment: Alignment.center,
  //           padding: EdgeInsets.symmetric(
  //               vertical: Dimensions.paddingSize,
  //               horizontal: Dimensions.paddingSize * 1.5),
  //           child: TitleHeading1Widget(
  //             text: Strings.pending,
  //           ),
  //         ),
  //       ),
  //       Visibility(
  //         visible: data == 1,
  //         child: Container(
  //           decoration: BoxDecoration(
  //               color: CustomColor.whiteColor,
  //               borderRadius: BorderRadius.circular(Dimensions.radius)),
  //           alignment: Alignment.center,
  //           padding: EdgeInsets.symmetric(
  //               vertical: Dimensions.paddingSize,
  //               horizontal: Dimensions.paddingSize * 1.5),
  //           child: TitleHeading1Widget(
  //             text: Strings.verified,
  //           ),
  //         ),
  //       )
  //     ],
  //   );
  // }
}
