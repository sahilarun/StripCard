import 'package:get_storage/get_storage.dart';
import 'package:stripcard/utils/basic_screen_import.dart';
import 'package:flutter/services.dart';
import 'backend/utils/network_check/dependency_injection.dart';
import 'utils/theme.dart';

void main() async {
  // Locking Device Orientation
  WidgetsFlutterBinding.ensureInitialized();
  SystemChrome.setPreferredOrientations([
    DeviceOrientation.portraitUp,
    DeviceOrientation.portraitDown,
  ]);
  SystemChrome.setSystemUIOverlayStyle(SystemUiOverlayStyle(
    statusBarColor: CustomColor.primaryLightScaffoldBackgroundColor,
  ));
  InternetCheckDependencyInjection.init();
  GetStorage.init();
  // main app
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return ScreenUtilInit(
      useInheritedMediaQuery: true,
      designSize: const Size(414, 896),
      builder: (_, child) => GetMaterialApp(
        title: Strings.appName,
        debugShowCheckedModeBanner: false,
        theme: Themes.light,
        darkTheme: Themes.dark,
        themeMode: Themes().theme,
        navigatorKey: Get.key,
        initialRoute: Routes.splashScreen,
        getPages: Routes.list,
        // translations: LocalString(),
        // locale: const Locale('ar', 'AR'),
        builder: (context, widget) {
          ScreenUtil.init(context);
          return MediaQuery(
              data: MediaQuery.of(context).copyWith(textScaleFactor: 1.0),
              child: widget!);
        },
      ),
    );
  }
}
