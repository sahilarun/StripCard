import 'package:get/get.dart';

import 'internet_connection_controller.dart';

class InternetCheckDependencyInjection {
  static void init() async {
    Get.put<NetworkController>(NetworkController(), permanent: true);
  }
}
