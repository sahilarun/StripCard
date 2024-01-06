import '../../language/strings.dart';

import '../custom_assets/assets.gen.dart';

class OnboardModel {
  final String image;
  final String title;
  final String subtitle;

  OnboardModel({
    required this.image,
    required this.title,
    required this.subtitle,
  });
}

List<OnboardModel> onboardData = [
  OnboardModel(
    image: Assets.onboard.oneOnboard.path,
    title: Strings.onBoardTitle1,
    subtitle: Strings.onBoardSubTitle1,
  ),
  OnboardModel(
   image: Assets.onboard.twoOnboard.path,
    title: Strings.onBoardTitle2,
    subtitle: Strings.onBoardSubTitle1,
  )
];
