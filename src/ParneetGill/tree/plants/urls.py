from django.urls import path
from . import views
from django.contrib.auth import views as auth_views

urlpatterns = [ # it defines different urls and what page it will on when a user select certain ooption or visit certain page. so it specifies the route from one page to another 
    path('', views.home, name='home'),
    path('api/plants', views.plant_list, name='plant_list'),
    path('add/', views.add_plant, name='add_plant'),
    path('signup/', views.signup, name='signup'),
    path('accounts/login/', auth_views.LoginView.as_view(), name='login'),
    path('logout/', auth_views.LogoutView.as_view(), name='logout'),
    path('logout/', auth_views.LogoutView.as_view(next_page='home'), name='logout'),

]


