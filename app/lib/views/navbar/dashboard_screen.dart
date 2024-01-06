import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/controller/categories/virtual_card/stripe_card/stripe_card_controller.dart';
import 'package:stripcard/controller/navbar/dashboard_controller.dart';
import 'package:stripcard/controller/navbar/navbar_controller.dart';
import 'package:stripcard/utils/basic_screen_import.dart';
import 'package:stripcard/widgets/others/custom_glass/custom_glass_widget.dart';
import '../../controller/navbar/usefull_link_controller.dart';
import '../../data/categories_data.dart';
import '../../widgets/bottom_navbar/categorie_widget.dart';
import '../../widgets/bottom_navbar/stripe_slider_card.dart';
import '../../widgets/bottom_navbar/transaction_history_widget.dart';
import 'package:intl/intl.dart';

class DashboardScreen extends StatelessWidget {
  DashboardScreen({super.key});
  final dashBoardController = Get.put(DashBoardController());
  final myCardController = Get.put(StripeCardController());
  final useFullLinkController = Get.put(UseFullLinkController());

  @override
  Widget build(BuildContext context) {
    return ResponsiveLayout(
      mobileScaffold: Scaffold(
        body: Obx(
          () => myCardController.isLoading ||
                  dashBoardController.isLoading ||
                  useFullLinkController.isLoading
              ? CustomLoadingAPI(
                  color: CustomColor.primaryLightColor,
                )
              : _bodyWidget(context),
        ),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    return Stack(
      children: [
        RefreshIndicator(
          color: CustomColor.primaryLightColor,
          onRefresh: () async {
            dashBoardController.getDashboardData();
          },
          child: ListView(
            children: [
              _appBarContainer(context),
              _cardWidget(context),
              //_noDataWidget(),
            ],
          ),
        ),
        _draggableSheet(context),
      ],
    );
  }

  _draggableSheet(BuildContext context) {
    var data = dashBoardController.dashBoardModel.data.transactions;
    return Visibility(
      visible: data.isNotEmpty,
      child: DraggableScrollableSheet(
        builder: (_, scrollController) {
          return _transactionWidget(context, scrollController);
        },
        initialChildSize: 0.29,
        minChildSize: 0.29,
        maxChildSize: 1,
      ),
    );
  }

  _appBarContainer(BuildContext context) {
    var data = dashBoardController.dashBoardModel.data;
    return Container(
      alignment: Alignment.center,
      height: MediaQuery.of(context).size.height * 0.17,
      decoration: BoxDecoration(
          color: CustomColor.primaryBGLightColor,
          borderRadius: BorderRadius.only(
            bottomLeft: Radius.circular(Dimensions.radius * 2),
            bottomRight: Radius.circular(Dimensions.radius * 2),
          )),
      child: Column(
        mainAxisAlignment: mainCenter,
        children: [
          CustomTitleHeadingWidget(
            text:
                "${data.userWallet.balance.toString()} ${data.userWallet.currency}",
            style: CustomStyle.darkHeading1TextStyle.copyWith(
              fontSize: Dimensions.headingTextSize4 * 2,
              fontWeight: FontWeight.w800,
              color: CustomColor.whiteColor,
            ),
          ),
          CustomTitleHeadingWidget(
            text: Strings.currentBalance,
            style: CustomStyle.lightHeading4TextStyle.copyWith(
              fontSize: Dimensions.headingTextSize3,
              color: CustomColor.whiteColor.withOpacity(0.6),
            ),
          ),
        ],
      ),
    );
  }

  _cardWidget(BuildContext context) {
    var width = MediaQuery.of(context).size.width;
    return Container(
      width: width,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(
          Dimensions.radius * 2,
        ),
        color: CustomColor.primaryBGLightColor,
      ),
      margin: EdgeInsets.symmetric(
        horizontal: Dimensions.marginSizeHorizontal * 0.8,
        vertical: Dimensions.marginSizeVertical * 0.4,
      ),
      padding: EdgeInsets.symmetric(
        horizontal: Dimensions.paddingSize * 0.8,
        vertical: Dimensions.paddingSize * 0.4,
      ),
      child: Column(
        mainAxisAlignment: mainCenter,
        children: [
          _cardRowWidget(context),
          _card(context),
          _cardCategories(context),
        ],
      ),
    );
  }

  _transactionWidget(BuildContext context, ScrollController scrollController) {
    var data = dashBoardController.dashBoardModel.data.transactions;

    return data.isEmpty
        ? Container()
        : ListView(
            padding:
                EdgeInsets.symmetric(horizontal: Dimensions.paddingSize * 0.8),
            physics: NeverScrollableScrollPhysics(),
            children: [
              verticalSpace(Dimensions.heightSize),
              CustomTitleHeadingWidget(
                text: Strings.recentTransaction,
                style: Get.isDarkMode
                    ? CustomStyle.lightHeading3TextStyle.copyWith(
                        fontSize: Dimensions.headingTextSize2,
                        fontWeight: FontWeight.w600,
                        color: CustomColor.primaryLightTextColor)
                    : CustomStyle.darkHeading3TextStyle.copyWith(
                        fontSize: Dimensions.headingTextSize2,
                        fontWeight: FontWeight.w600,
                        color: CustomColor.primaryLightTextColor),
              ),
              verticalSpace(Dimensions.widthSize),
              SizedBox(
                height: MediaQuery.of(context).size.height,
                child: ListView.builder(
                    controller: scrollController,
                    physics: BouncingScrollPhysics(),
                    itemCount: data.length,
                    itemBuilder: (context, index) {
                      return TransactionWidget(
                        amount: data[index].requestAmount,
                        title: data[index].transactionType,
                        dateText: DateFormat.M().format(data[index].dateTime),
                        transaction: data[index].trx,
                        monthText:
                            DateFormat.MMMM().format(data[index].dateTime),
                      );
                    }),
              )
            ],
          ).customGlassWidget();
  }

  _cardRowWidget(BuildContext context) {
    final controller = Get.put(NavbarController());
    return Container(
      margin: EdgeInsets.only(bottom: Dimensions.marginSizeVertical * 0.3),
      child: Row(
        mainAxisAlignment: mainSpaceBet,
        children: [
          TitleHeading2Widget(
            text: Strings.myCard.tr,
            fontWeight: FontWeight.w600,
          ),
          GestureDetector(
            onTap: () {
              controller.selectedIndex.value = 3;
            },
            child: TitleHeading4Widget(
              text: Strings.viewAll.tr,
              fontWeight: FontWeight.w600,
            ),
          ),
        ],
      ),
    );
  }

  _card(BuildContext context) {
    return DashboardSlider();
  }

  _cardCategories(BuildContext context) {
    return SizedBox(
      height: MediaQuery.sizeOf(context).height * 0.1,
      child: GridView.count(
        padding: EdgeInsets.only(top: Dimensions.paddingSize * 0.1),
        physics: NeverScrollableScrollPhysics(),
        crossAxisCount: 2,
        crossAxisSpacing: 2.0,
        mainAxisSpacing: 2.0,
        shrinkWrap: true,
        children: List.generate(
          categoriesData.length,
          (index) => CategoriesWidget(
            color: CustomColor.primaryLightTextColor,
            onTap: categoriesData[index].onTap,
            icon: categoriesData[index].icon,
            text: categoriesData[index].text,
          ),
        ),
      ),
    );
  }
}
