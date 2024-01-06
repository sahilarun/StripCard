import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../../utils/custom_color.dart';
import '../../utils/custom_style.dart';
import '../../utils/dimensions.dart';

class KycDynamicDropDown extends StatelessWidget {
  final RxString selectMethod;
  final List<String> itemsList;
  final void Function(String?)? onChanged;

  const KycDynamicDropDown({
    required this.itemsList,
    Key? key,
    required this.selectMethod,
    this.onChanged,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Obx(() => Container(
          height: Dimensions.inputBoxHeight * .75,
          decoration: BoxDecoration(
            border: Border.all(
              color: CustomColor.primaryLightTextColor.withOpacity(0.2),
              width: 1,
            ),
            borderRadius: BorderRadius.circular(Dimensions.radius * 0.5),
          ),
          child: DropdownButtonHideUnderline(
            child: Padding(
              padding: const EdgeInsets.only(left: 5, right: 20),
              child: DropdownButton(
                dropdownColor: CustomColor.primaryBGDarkColor,
                hint: Padding(
                  padding: EdgeInsets.only(left: Dimensions.paddingSize * 0.7),
                  child: Text(
                    selectMethod.value,
                    style: CustomStyle.darkHeading3TextStyle.copyWith(
                      color: CustomColor.primaryLightTextColor,
                    ),
                  ),
                ),
                icon: Padding(
                  padding: const EdgeInsets.only(right: 4),
                  child: Icon(
                    Icons.arrow_drop_down,
                    color: CustomColor.primaryLightTextColor,
                  ),
                ),
                isExpanded: true,
                underline: Container(),
                borderRadius: BorderRadius.circular(Dimensions.radius),
                items: itemsList.map<DropdownMenuItem<String>>((value) {
                  return DropdownMenuItem<String>(
                    value: value,
                    child: Text(
                      value.toString(),
                      style: CustomStyle.lightHeading3TextStyle,
                    ),
                  );
                }).toList(),
                onChanged: onChanged,
              ),
            ),
          ),
        ));
  }
}
