import 'package:stripcard/backend/utils/custom_loading_api.dart';
import 'package:stripcard/controller/categories/virtual_card/stripe_card/stripe_card_controller.dart';
import 'package:stripcard/utils/basic_screen_import.dart';
import '../../data/categories_data.dart';
import '../../widgets/bottom_navbar/categorie_widget.dart';
import '../../widgets/bottom_navbar/stripe_slider_card.dart';

class MyCardScreen extends StatelessWidget {
  MyCardScreen({super.key});
  final stripeCardController = Get.put(StripeCardController());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false,
        title: Text(
          Strings.myCard,
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
        () => stripeCardController.isLoading
            ? CustomLoadingAPI(color: CustomColor.primaryLightColor)
            : _bodyWidget(context),
      ),
    );
  }

  _bodyWidget(BuildContext context) {
    return Padding(
      padding: EdgeInsets.symmetric(horizontal: Dimensions.paddingSize),
      child: Column(
        mainAxisAlignment:
            stripeCardController.stripeCardModel.data.myCard.isNotEmpty
                ? mainStart
                : mainCenter,
        children: [
          _card(context),
          _cardCategories(context),
          _createCard(context),
        ],
      ),
    );
  }

  _card(BuildContext context) {
    return Visibility(
      visible: stripeCardController.stripeCardModel.data.myCard.isNotEmpty,
      child: DashboardSlider(),
    );
  }

  _cardCategories(BuildContext context) {
    return Visibility(
      visible: stripeCardController.stripeCardModel.data.myCard.isNotEmpty,
      child: Container(
        margin: EdgeInsets.symmetric(vertical: Dimensions.marginSizeVertical),
        child: SizedBox(
          height: MediaQuery.sizeOf(context).height * 0.1,
          child: GridView.count(
            padding: EdgeInsets.only(top: Dimensions.paddingSize * 0.3),
            physics: NeverScrollableScrollPhysics(),
            scrollDirection: Axis.vertical,
            crossAxisCount: 2,
            crossAxisSpacing: 1.0,
            mainAxisSpacing: 3.0,
            shrinkWrap: true,
            children: List.generate(
              categoriesData.length,
              (index) => CategoriesWidget(
                color: CustomColor.primaryLightColor,
                onTap: categoriesData[index].onTap,
                icon: categoriesData[index].icon,
                text: categoriesData[index].text,
              ),
            ),
          ),
        ),
      ),
    );
  }

  _createCard(BuildContext context) {
    return Center(
      child: GestureDetector(
        onTap: () {
          Get.toNamed(Routes.stripeCreateCardScreen);
        },
        child: Container(
          alignment: Alignment.center,
          height: Dimensions.heightSize * 4.5,
          width: MediaQuery.of(context).size.width * 0.6,
          margin: EdgeInsets.symmetric(vertical: Dimensions.marginSizeVertical),
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(
              Dimensions.radius * 3.5,
            ),
            border: Border.all(
              color: CustomColor.primaryBGLightColor,
              width: 2,
            ),
          ),
          child: TitleHeading3Widget(
            text: Strings.createANewCard,
            color: CustomColor.primaryBGLightColor,
          ),
        ),
      ),
    );
  }
}
