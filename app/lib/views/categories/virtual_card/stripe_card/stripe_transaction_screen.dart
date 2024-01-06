import 'package:intl/intl.dart';
import '../../../../backend/utils/custom_loading_api.dart';
import '../../../../controller/categories/virtual_card/stripe_card/stripe_transaction_controller.dart';
import '../../../../utils/basic_screen_import.dart';
import '../../../../widgets/appbar/appbar_widget.dart';
import '../../../../widgets/bottom_navbar/transaction_history_widget.dart';

class StripeTransactionHistoryScreen extends StatelessWidget {
  StripeTransactionHistoryScreen({super.key});
  final controller = Get.put(StripeTransactionController());

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        appBar: AppBarWidget(text: Strings.transactionHistory),
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
    var data = controller.stripeCardTransactionsModel.data.cardTransactions;

    return data.isNotEmpty
        ? RefreshIndicator(
            color: CustomColor.primaryLightColor,
            onRefresh: () async {
              controller.getCardTransactionHistory();
            },
            child: ListView.builder(
                padding: EdgeInsets.symmetric(
                  horizontal: Dimensions.marginSizeHorizontal * 0.9,
                ),
                itemCount: data.length,
                itemBuilder: (context, index) {
                  return TransactionWidget(
                    amount: data[index].amount,
                    title: '${'Trx'} ${data[index].trx}',
                    dateText: DateFormat.M().format(data[index].date),
                    transaction: data[index].status,
                    monthText: DateFormat.MMMM().format(data[index].date),
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
