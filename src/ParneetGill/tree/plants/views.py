from django.http import JsonResponse
from .models import Plant
from django.http import HttpResponse
from django.shortcuts import render, redirect
from .forms import PlantForm
from django.contrib.auth.decorators import login_required
from .forms import SignUpForm

# this file handles the request which will come in from the user and what actions will be taken when a user sign up, 
# adds a plant or log in into their account
def home(request): # this takes to the home page of the application
    return render(request, 'plants/home.html')

def signup(request): # when a user sign up, it handles all the necessary things from sending user to sign up page
    # and once has successfully created an account, save the user details and redirect to login page. it also tackles 
    # if there is a error or the information is wrong  
    if request.method == 'POST':
        form = SignUpForm(request.POST) # request sign up form 
        if form.is_valid():
            user = form.save(commit=False)
            user.email = form.cleaned_data.get('email') # get the email of the user 
            user.save() # save the user if all the fields are filled correctly
            print("User created:", user.username)
            # then the user is sent to the login page 
            return redirect('login')  
        else:
            # if the form is not valid then throws an error
            print("Form is not valid:", form.errors) 
    else:
        form = SignUpForm()
    return render(request, 'plants/signup.html', {'form': form})

# first if the user needds to add a plant, user must be logged in, then it provides a plant form for user to fill
# the details of the planty and then it will redirect to a page where all the plants that had been added by the 
#current user will appear 
@login_required
def add_plant(request):
    if request.method == 'POST':
        form = PlantForm(request.POST)
        # request the form and make sure that form is valid 
        if form.is_valid():
            plant = form.save(commit=False)
            plant.user = request.user
            # save the plant to the desired user if the form is correctly filled
            plant.save()
            # after saving it will automatically redirect to a page with the plant list 
            return redirect('plant_list')
    else:
        form = PlantForm()
    return render(request, 'plants/add_plant.html', {'form': form})

# shows the list of the plants associated with the currrent logged in user. 
def plant_list(request):
    plants = Plant.objects.filter(user=request.user)
    return render(request, 'plants/plant_list.html', {'plants': plants})

