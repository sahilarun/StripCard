import 'package:flutter/material.dart';
import 'package:flutter_svg/svg.dart';

class CustomImageWidget extends StatelessWidget {
  const CustomImageWidget({
    Key? key,
    required this.path,
    this.height = 20.00,
    this.width = 25.00,
    this.scale = 1.0,
    this.borderRadius = BorderRadius.zero,
    this.color,
    this.fit,
  }) : super(key: key);

  final String path;
  final double? height;
  final double? width;
  final double scale;
  final BorderRadiusGeometry borderRadius;
  final Color? color;
  final BoxFit? fit;

  String getFileExtension(String fileName) {
    try {
      return ".${fileName.split('.').last}";
    } catch (e) {
      return '';
    }
  }

  @override
  Widget build(BuildContext context) {
    final extension = getFileExtension(path);
    return extension == '.svg'
        ? ClipRRect(
            borderRadius: borderRadius,
            child: SvgPicture.asset(
              path,
              height: height,
              width: width,
           color:
                  color, 
              fit: fit ?? BoxFit.contain,
            ),
          )
        : ClipRRect(
            borderRadius: borderRadius,
            child: Image.asset(
              path,
              scale: scale,
              height: height,
              width: width,
              fit: fit ?? BoxFit.contain,
            ),
          );
  }
}
