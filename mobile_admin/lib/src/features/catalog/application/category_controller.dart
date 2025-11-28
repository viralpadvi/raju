import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:image_picker/image_picker.dart';

import '../data/category_repository.dart';
import '../domain/category_models.dart';

final categoryControllerProvider =
    StateNotifierProvider<CategoryController, CategoryState>((ref) {
  final repository = ref.watch(categoryRepositoryProvider);
  final controller = CategoryController(repository: repository);
  controller.bootstrap();
  return controller;
});

class CategoryController extends StateNotifier<CategoryState> {
  CategoryController({required CategoryRepository repository})
      : _repository = repository,
        super(const CategoryState.initial());

  final CategoryRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh({bool activeOnly = false}) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final categories =
          await _repository.fetchCategories(status: activeOnly ? true : null);
      final treeCategories =
          await _repository.fetchCategories(tree: true, status: activeOnly ? true : null);
      state = state.copyWith(
        isLoading: false,
        categories: categories,
        treeCategories: treeCategories,
      );
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> createCategory(CategoryPayload payload, {XFile? imageFile}) async {
    try {
      final category = await _repository.createCategory(payload, imageFile: imageFile);
      final updated = [...state.categories, category];
      state = state.copyWith(categories: updated);
      await refresh(); // Refresh tree as well
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateCategory(int id, CategoryPayload payload, {XFile? imageFile}) async {
    try {
      final category = await _repository.updateCategory(id, payload, imageFile: imageFile);
      final updated =
          state.categories.map((c) => c.id == id ? category : c).toList();
      state = state.copyWith(categories: updated);
      await refresh(); // Refresh tree as well
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteCategory(int id) async {
    try {
      await _repository.deleteCategory(id);
      final updated = state.categories.where((c) => c.id != id).toList();
      state = state.copyWith(categories: updated);
      await refresh(); // Refresh tree as well
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class CategoryState {
  const CategoryState({
    required this.isLoading,
    required this.categories,
    required this.treeCategories,
    required this.errorMessage,
  });

  const CategoryState.initial()
      : isLoading = false,
        categories = const [],
        treeCategories = const [],
        errorMessage = null;

  final bool isLoading;
  final List<CategoryDto> categories;
  final List<CategoryDto> treeCategories;
  final String? errorMessage;

  CategoryState copyWith({
    bool? isLoading,
    List<CategoryDto>? categories,
    List<CategoryDto>? treeCategories,
    String? errorMessage,
  }) {
    return CategoryState(
      isLoading: isLoading ?? this.isLoading,
      categories: categories ?? this.categories,
      treeCategories: treeCategories ?? this.treeCategories,
      errorMessage: errorMessage,
    );
  }
}

