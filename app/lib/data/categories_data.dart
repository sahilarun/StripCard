import 'package:stripcard/backend/utils/custom_snackbar.dart';
import 'package:stripcard/model/categories_model.dart';
import 'package:stripcard/utils/basic_screen_import.dart';
import '../controller/categories/virtual_card/stripe_card/stripe_card_controller.dart';
import '../controller/navbar/navbar_controller.dart';

final myCardController = Get.put(StripeCardController());
final controller = Get.put(NavbarController());

List<CategoriesModel> categoriesData = [
  CategoriesModel(Assets.icon.detailsCard, Strings.details, () {
    myCardController.getStripeCardData();
    if (myCardController.stripeCardModel.data.myCard.isNotEmpty) {
      Get.toNamed(Routes.stripeCardDetailsScreen);
    } else {
      CustomSnackBar.error(Strings.youDonNotBuyCard);
    }
  }),
  CategoriesModel(Assets.icon.transactionCard, Strings.transaction, () {
    myCardController.getStripeCardData();
    if (myCardController.stripeCardModel.data.myCard.isNotEmpty) {
      Get.toNamed(Routes.stripeTransactionHistoryScreen);
    } else {
      CustomSnackBar.error(
        Strings.youDonNotBuyCard,
      );
    }
  }),
];
