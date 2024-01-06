import 'package:stripcard/controller/navbar/navbar_controller.dart';
import 'package:stripcard/utils/basic_screen_import.dart';
import 'package:stripcard/views/others/custom_image_widget.dart';
import '../../controller/navbar/dashboard_controller.dart';
import '../../widgets/bottom_navbar/bottom_navber.dart';
import '../../widgets/drawer/drawer_widget.dart';

class BottomNavBarScreen extends StatelessWidget {
  final bottomNavBarController = Get.put(NavbarController(), permanent: false);
  final GlobalKey<ScaffoldState> scaffoldKey = GlobalKey();

  BottomNavBarScreen({Key? key}) : super(key: key);
  final dashBoardController = Get.put(DashBoardController());
  @override
  Widget build(BuildContext context) {
    return Obx(
      () => Scaffold(
        drawer: CustomDrawer(),
        key: scaffoldKey,
        appBar: appBarWidget(context),
        extendBody: true,
        backgroundColor: CustomColor.primaryLightColor,
        bottomNavigationBar:
            buildBottomNavigationMenu(context, bottomNavBarController),
        floatingActionButtonLocation: FloatingActionButtonLocation.centerDocked,
        body: bottomNavBarController
            .page[bottomNavBarController.selectedIndex.value],
      ),
    );
  }

  appBarWidget(BuildContext context) {
    return bottomNavBarController.selectedIndex.value == 0
        ? AppBar(
            backgroundColor: bottomNavBarController.selectedIndex.value == 0
                ? CustomColor.primaryBGLightColor
                : CustomColor.primaryLightScaffoldBackgroundColor,
            elevation: bottomNavBarController.selectedIndex.value == 0 ? 0 : 0,
            centerTitle:
                bottomNavBarController.selectedIndex.value == 0 ? true : false,
            leading: bottomNavBarController.selectedIndex.value == 0
                ? GestureDetector(
                    onTap: () {
                      if (dashBoardController.isLoading == false) {
                        scaffoldKey.currentState!.openDrawer();
                      }
                    },
                    child: Padding(
                        padding: EdgeInsets.only(
                            left: Dimensions.paddingSize,
                            right: Dimensions.paddingSize * 0.2),
                        child: CustomImageWidget(
                          path: Assets.icon.drawerMenu,
                          height: 17.h,
                          width: 17.w,
                          color: CustomColor.whiteColor,
                        )),
                  )
                : Container(),
            title: bottomNavBarController.selectedIndex.value == 0
                ? Padding(
                    padding: EdgeInsets.all(Dimensions.paddingSize * 1.2),
                    child: TitleHeading4Widget(
                      text:Strings.appName,
                      fontWeight: FontWeight.w600,
                      color: CustomColor.whiteColor,
                      fontSize: Dimensions.headingTextSize5 * 2,
                    ),
                  )
                : Container(),
            actions: [
              bottomNavBarController.selectedIndex.value == 0
                  ? Padding(
                      padding:
                          EdgeInsets.only(right: Dimensions.paddingSize * 0.6),
                      child: GestureDetector(
                        onTap: () {
                          Get.toNamed(Routes.updateProfileScreen);
                        },
                        child: CustomImageWidget(
                          path: Assets.icon.profile,
                          height: 28.h,
                          width: 28.w,
                          color: CustomColor.whiteColor,
                        ),
                      ),
                    )
                  : Container()
            ],
          )
        : null;
  }
}
