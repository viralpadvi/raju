import 'package:flex_color_scheme/flex_color_scheme.dart';
import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

final appThemeProvider = Provider<AppTheme>((ref) {
  const seed = Color(0xFF6366F1); // Modern indigo
  final light = FlexThemeData.light(
    scheme: FlexScheme.indigo,
    useMaterial3: true,
    surfaceMode: FlexSurfaceMode.levelSurfacesLowScaffold,
    blendLevel: 7,
    subThemesData: const FlexSubThemesData(
      blendOnLevel: 10,
      blendOnColors: false,
      inputDecoratorFillColor: Colors.transparent,
      inputDecoratorIsFilled: false,
      inputDecoratorBorderWidth: 1.5,
      inputDecoratorRadius: 12,
      cardRadius: 16,
      elevatedButtonRadius: 12,
      outlinedButtonRadius: 12,
      filledButtonRadius: 12,
      textButtonRadius: 8,
      chipRadius: 8,
    ),
    visualDensity: FlexColorScheme.comfortablePlatformDensity,
    useMaterial3ErrorColors: true,
    primaryTextTheme: Typography.material2021().black,
    textTheme: Typography.material2021().black,
  );

  final dark = FlexThemeData.dark(
    scheme: FlexScheme.indigo,
    useMaterial3: true,
    surfaceMode: FlexSurfaceMode.levelSurfacesLowScaffold,
    blendLevel: 13,
    subThemesData: const FlexSubThemesData(
      blendOnLevel: 20,
      blendOnColors: false,
      inputDecoratorFillColor: Colors.transparent,
      inputDecoratorIsFilled: false,
      inputDecoratorBorderWidth: 1.5,
      inputDecoratorRadius: 12,
      cardRadius: 16,
      elevatedButtonRadius: 12,
      outlinedButtonRadius: 12,
      filledButtonRadius: 12,
      textButtonRadius: 8,
      chipRadius: 8,
    ),
    visualDensity: FlexColorScheme.comfortablePlatformDensity,
    useMaterial3ErrorColors: true,
    primaryTextTheme: Typography.material2021().white,
    textTheme: Typography.material2021().white,
  );

  return AppTheme(light: light, dark: dark, seedColor: seed);
});

class AppTheme {
  const AppTheme({
    required this.light,
    required this.dark,
    required this.seedColor,
  });

  final ThemeData light;
  final ThemeData dark;
  final Color seedColor;
}

