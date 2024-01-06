import 'package:intl/intl.dart';
import '../../backend/utils/custom_loading_api.dart';
import '../../controller/navbar/dashboard_controller.dart';
import 'package:stripcard/utils/basic_screen_import.dart';

import '../../widgets/bottom_navbar/transaction_history_widget.dart';

class NotificationScreen extends StatelessWidget {
  NotificationScreen({super.key});
  final dashBoardController = Get.put(DashBoardController());

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        appBar: AppBar(
          title: Text(
            Strings.notification,
            style: CustomStyle.darkHeading4TextStyle.copyWith(
              fontSize: Dimensions.headingTextSize1,
              fontWeight: FontWeight.w500,
              color: CustomColor.primaryLightTextColor,
            ),
          ),
          centerTitle: true,
          elevation: 0,
          backgroundColor: CustomColor.primaryLightScaffoldBackgroundColor,
          leading: Container(),
        ),
        body: Obx(
          () => dashBoardController.isLoading
              ? CustomLoadingAPI(
                  color: CustomColor.primaryLightColor,
                )
              : _bodyWidget(context),
        ),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    var data = dashBoardController.dashBoardModel.data.transactions;

    return data.isNotEmpty
        ? RefreshIndicator(
            color: CustomColor.primaryLightColor,
            onRefresh: () async {
              dashBoardController.getDashboardData();
            },
            child: ListView.builder(
                padding: EdgeInsets.symmetric(
                  horizontal: Dimensions.marginSizeHorizontal * 0.9,
                ),
                itemCount: data.length,
                itemBuilder: (context, index) {
                  return TransactionWidget(
                    amount: data[index].requestAmount,
                    title: data[index].transactionType,
                    dateText: DateFormat.M().format(data[index].dateTime),
                    transaction: data[index].trx,
                    monthText: DateFormat.MMMM().format(data[index].dateTime),
                  );
                }),
          )
        : Center(
            child: TitleHeading1Widget(
              text: Strings.noRecordFound,
              color: CustomColor.primaryLightColor,
            ),
          );
  }
}
