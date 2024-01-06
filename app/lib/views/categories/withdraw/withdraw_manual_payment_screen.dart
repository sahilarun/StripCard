import '../../../controller/navbar/withdraw/withdraw_controller.dart';
import '../../../utils/basic_screen_import.dart';
import '../../../widgets/appbar/appbar_widget.dart';

class MoneyOutManualPaymentScreen extends StatelessWidget {
  MoneyOutManualPaymentScreen({super.key});

  final controller = Get.put(MoneyOutController());
  final formKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBarWidget(text: Strings.evidenceNote),
      body: _bodyWidget(context),
    );
  }

  _bodyWidget(BuildContext context) {
    return Padding(
      padding: EdgeInsets.symmetric(
        horizontal: Dimensions.paddingSize * 0.7,
        vertical: Dimensions.paddingSize * 0.7,
      ),
      child: Form(
        key: formKey,
        child: ListView(
          physics: const BouncingScrollPhysics(),
          children: [
            ...controller.inputFields.map((element) {
              return element;
            }).toList(),
            _buttonWidget(context)
          ],
        ),
      ),
    );
  }

  _buttonWidget(BuildContext context) {
    return Container(
      margin: EdgeInsets.symmetric(vertical: Dimensions.marginSizeVertical),
      child: PrimaryButton(
        title: Strings.submit,
        onPressed: () {
          if (formKey.currentState!.validate()) {
            Get.toNamed(Routes.moneyOutPreviewScreen);
          }
        },
      ),
    );
  }
}
