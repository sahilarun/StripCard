import 'package:flutter/material.dart';

import 'dimensions.dart';

class ResponsiveLayout extends StatelessWidget {
  final Widget mobileScaffold;
  final Widget? tabletScaffold;
  final Widget? desktopScaffold;

  const ResponsiveLayout(
      {super.key,
      required this.mobileScaffold,
      this.tabletScaffold,
      this.desktopScaffold});

  @override
  Widget build(BuildContext context) {
    return LayoutBuilder(
      builder: (context, constraints) {
        if (constraints.maxWidth < Dimensions.mobileScreenWidth) {
          return mobileScaffold;
        } else if (constraints.maxWidth < Dimensions.tabletScreenWidth) {
          return tabletScaffold ?? mobileScaffold;
        } else {
          return desktopScaffold ?? mobileScaffold;
        }
      },
    );
  }
}
