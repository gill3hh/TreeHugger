from django import forms
from .models import Plant
from django.contrib.auth.forms import UserCreationForm
from django.contrib.auth.models import User

# so in this we have forms that i made in different pages and takes the input by using the django form fileds

class SignUpForm(UserCreationForm): # when a new user wanted to sign up i have a new form which takes these fields and also added email field 
    #which makes sure that correct email is entered 
    email = forms.EmailField(required=True)

    class Meta:
        model = User
        fields = ['username', 'email', 'password1', 'password2']

class PlantForm(forms.ModelForm): # it provides fields for a form for user in which we have name, desc and image url when user adds a new plant
    class Meta:
        model = Plant
        fields = ['name', 'description', 'image_url']

