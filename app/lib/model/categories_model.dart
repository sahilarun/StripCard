import 'package:flutter/material.dart';

class CategoriesModel {
  final String icon, text;
  final VoidCallback onTap;

  CategoriesModel(this.icon, this.text, this.onTap);
}
