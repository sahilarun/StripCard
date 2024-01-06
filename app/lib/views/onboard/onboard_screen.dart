import 'package:stripcard/backend/services/api_endpoint.dart';
import 'package:cached_network_image/cached_network_image.dart';

import '../../backend/local_storage.dart';
import '../../controller/app_settings/app_settings_controller.dart';
import '../../controller/onbaoard_controller/onboard_controller.dart';
import '../../utils/basic_screen_import.dart';

class OnboardScreen extends StatelessWidget {
  OnboardScreen({Key? key}) : super(key: key);
  final controller = Get.put(OnBoardController());
  final appSettingsController = Get.put(AppSettingsController());

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        backgroundColor: Theme.of(context).scaffoldBackgroundColor,
        body: Column(children: [
          SizedBox(
            height: MediaQuery.of(context).size.height * 0.38,
            child: Column(
              mainAxisAlignment: mainCenter,
              children: [
                verticalSpace(MediaQuery.of(context).size.height * 0.1),
                Container(
                  padding: EdgeInsets.all(Dimensions.paddingSize),
                  child: Image.network(
                    LocalStorage.getBasicImage(),
                    height: MediaQuery.of(context).size.height * 0.12,
                    width: MediaQuery.of(context).size.width * 0.5,
                  ),
                ),
              ],
            ),
          ),
          SizedBox(
            height: MediaQuery.of(context).size.height * 0.62,
            child: PageView.builder(
              physics: const BouncingScrollPhysics(),
              controller: controller.pageController,
              onPageChanged: controller.selectedIndex,
              itemCount: appSettingsController.onboardScreen.length,
              itemBuilder: (context, index) {
                var data = appSettingsController.onboardScreen[index];
                return Column(
                  mainAxisAlignment: mainEnd,
                  children: [
                    CachedNetworkImage(
                      height: MediaQuery.of(context).size.height * 0.34,
                      imageUrl:
                          "${ApiEndpoint.mainDomain}/${appSettingsController.appSettingsModel.data.imagePath}/${data.image}",
                      placeholder: (context, url) => Container(),
                      errorWidget: (context, url, error) => Container(),
                    ),
                    _bottomContainerWidget(context,
                        child: Column(
                          children: [
                            _titleAndSubTitleWidget(context, data),
                            Padding(
                              padding: EdgeInsets.symmetric(
                                vertical: Dimensions.paddingSize * 0.6,
                              ),
                              child: Row(
                                mainAxisAlignment: mainSpaceBet,
                                children: [
                                  _skipButtonWidget(context),
                                  Obx(() => controller.dotWidget()),
                                  Obx(() => controller.arrowWidget()),
                                ],
                              ),
                            )
                          ],
                        )),
                  ],
                );
              },
            ),
          ),
        ]),
      ),
    );
  }
}

_bottomContainerWidget(BuildContext context, {required Widget child}) {
  Radius borderRadius = const Radius.circular(20);
  return Container(
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
            offset: const Offset(0, 0), // changes position of shadow
          ),
        ],
      ),
      padding: EdgeInsets.all(Dimensions.paddingSize),
      child: child,
      
      );
}

_titleAndSubTitleWidget(BuildContext context, data) {
  return Column(
    children: [
      Builder(builder: (context) {
        return TitleHeading2Widget(
          text: data.title,
          textAlign: TextAlign.start,
          maxLines: 2,
          textOverflow: TextOverflow.ellipsis,
          fontWeight: FontWeight.w800,
          color: CustomColor.whiteColor,
        );
      }),
      verticalSpace(Dimensions.heightSize * 0.4),
      TitleHeading4Widget(
        text: data.subTitle,
        textAlign: TextAlign.justify,
        maxLines: 3,
        textOverflow: TextOverflow.ellipsis,
        fontSize: Dimensions.headingTextSize4 * 0.8,
        color: CustomColor.whiteColor,
      ),
      verticalSpace(Dimensions.heightSize * 1)
    ],
  );
}

_skipButtonWidget(BuildContext context) {
  return InkWell(
    onTap: (() {
      LocalStorage.saveOnboardDoneOrNot(isOnBoardDone: true);
      Get.toNamed(Routes.signInScreen);
    }),
    child: TitleHeading4Widget(
      text: Strings.skip,
      fontSize: Dimensions.headingTextSize5,
      fontWeight: FontWeight.w500,
      color: CustomColor.whiteColor,
    ),
  );
}
